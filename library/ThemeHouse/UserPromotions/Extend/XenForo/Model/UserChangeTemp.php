<?php

/**
 *
 * @see XenForo_Model_UserChangeTemp
 */
class ThemeHouse_UserPromotions_Extend_XenForo_Model_UserChangeTemp extends XFCP_ThemeHouse_UserPromotions_Extend_XenForo_Model_UserChangeTemp
{

    /**
     *
     * @see XenForo_Model_UserChangeTemp::applyTempUserChange()
     */
    public function applyTempUserChange($userId, $actionType, $actionModifier, $newValue = null, $expiryDate = null, 
        $changeKey = null)
    {
        if ($actionType != 'custom_field') {
            return parent::applyTempUserChange($userId, $actionType, $actionModifier, $newValue, $expiryDate, 
                $changeKey);
        }
        
        /* @var $dw XenForo_DataWriter_User */
        $dw = XenForo_DataWriter::create('XenForo_DataWriter_User', XenForo_DataWriter::ERROR_SILENT);
        if (!$dw->setExistingData($userId)) {
            return false;
        }
        
        $db = $this->_getDb();
        
        XenForo_Db::beginTransaction($db);
        
        if ($changeKey !== null) {
            // the same change keys could change different fields, so need to
            // expire
            // the old one to replace it
            $this->expireTempUserChangeByKey($userId, $changeKey);
        }
        
        $oldValue = null;
        
        switch ($actionType) {
            case 'custom_field':
                $originalChange = $db->fetchRow(
                    "
					SELECT *
					FROM xf_user_change_temp
					WHERE user_id = ?
						AND action_type = 'custom_field'
						AND action_modifier = ?
					ORDER BY create_date
					LIMIT 1
				", 
                    array(
                        $userId,
                        $actionModifier
                    ));
                $customFields = @unserialize($dw->get('custom_fields'));
                $existingValue = isset($customFields[$actionModifier]) ? $customFields[$actionModifier] : '';
                $oldValue = $originalChange ? $originalChange['old_value'] : $existingValue;
                $fieldValues[$actionModifier] = $newValue;
                $fieldsShown = array_keys($fieldValues);
                $dw->setCustomFields($fieldValues, $fieldsShown);
                if ($dw->isChanged('custom_fields')) {
                    $dw->save();
                }
        }
        
        if (!is_scalar($newValue)) {
            $newValue = serialize($newValue);
        }
        if (!is_scalar($oldValue)) {
            $oldValue = serialize($oldValue);
        }
        if (!$expiryDate) {
            $expiryDate = null;
        }
        
        $record = array(
            'user_id' => $userId,
            'change_key' => $changeKey,
            'action_type' => $actionType,
            'action_modifier' => $actionModifier,
            'new_value' => $newValue,
            'old_value' => $oldValue,
            'create_date' => XenForo_Application::$time,
            'expiry_date' => $expiryDate
        );
        
        $db->insert('xf_user_change_temp', $record);
        $record['user_change_temp_id'] = $db->lastInsertId();
        
        XenForo_Db::commit($db);
        
        return $record;
    }

    public function expireTempUserChange(array $change)
    {
        $userId = $change['user_id'];
        $actionType = $change['action_type'];
        $actionModifier = $change['action_modifier'];
        
        if ($actionType != 'custom_field') {
            return parent::expireTempUserChange($change);
        }
        
        /**
         *
         * @var XenForo_DataWriter_User $dw
         */
        $dw = XenForo_DataWriter::create('XenForo_DataWriter_User', XenForo_DataWriter::ERROR_SILENT);
        if (!$dw->setExistingData($userId)) {
            return false;
        }
        
        $db = $this->_getDb();
        
        XenForo_Db::beginTransaction($db);
        
        $res = $db->query("
			DELETE FROM xf_user_change_temp
			WHERE user_change_temp_id = ?
		", $change['user_change_temp_id']);
        
        if (!$res->rowCount()) {
            // already deleted
            XenForo_Db::rollback($db);
            return false;
        }
        
        switch ($actionType) {
            case 'custom_field':
                $customFields = @unserialize($dw->get('custom_fields'));
                $currentValue = isset($customFields[$actionModifier]) ? $customFields[$actionModifier] : '';
                
                // if the field was changed to the current value, revert it
                // to the most recent new value or the original value if none
                if ($currentValue === $change['new_value']) {
                    $lastChange = $db->fetchRow(
                        "
						SELECT *
						FROM xf_user_change_temp
						WHERE user_id = ?
							AND action_type = 'custom_field'
							AND action_modifier = ?
						ORDER BY create_date DESC
						LIMIT 1
					", 
                        array(
                            $userId,
                            $actionModifier
                        ));
                    $oldValue = $lastChange ? $lastChange['new_value'] : $change['old_value'];
                    $fieldValues[$actionModifier] = $oldValue;
                    $fieldsShown = array_keys($fieldValues);
                    $dw->setCustomFields($fieldValues, $fieldsShown);
                    if ($dw->isChanged('custom_fields')) {
                        $dw->save();
                    }
                }
        }
        
        XenForo_Db::commit($db);
        
        return true;
    }
}