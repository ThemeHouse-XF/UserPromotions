<?php

/**
 *
 * @see XenForo_Model_UserGroupPromotion
 */
class ThemeHouse_UserPromotions_Extend_XenForo_Model_UserGroupPromotion extends XFCP_ThemeHouse_UserPromotions_Extend_XenForo_Model_UserGroupPromotion
{

    /**
     *
     * @see XenForo_Model_UserGroupPromotion::promoteUser()
     */
    public function promoteUser(array $promotion, $userId, $state = 'automatic')
    {
        $db = $this->_getDb();
        XenForo_Db::beginTransaction($db);
        
        $this->_getUserModel()->addUserGroupChange($userId, "ugPromotion$promotion[promotion_id]", 
            $promotion['extra_user_group_ids']);
        
        $customFields = @unserialize($promotion['custom_fields_th']);
        if ($customFields) {
            foreach ($customFields as $customFieldId => $customFieldValue) {
                if (is_string($customFieldValue)) {
                    $replace = array(
                        '{now}' => XenForo_Application::$time,
                        '{date}' => XenForo_Locale::date(XenForo_Application::$time, 'picker')
                    );
                    $customFieldValue = strtr($customFieldValue, $replace);
                }
                
                $this->_getUserChangeTempModel()->applyTempUserChange($userId, 'custom_field', $customFieldId, 
                    $customFieldValue, null, "ugPromotion$promotion[promotion_id]$customFieldId");
            }
        }
        
        $this->insertPromotionLogEntry($promotion['promotion_id'], $userId, $state);
        
        XenForo_Db::commit($db);
    }

    /**
     *
     * @see XenForo_Model_UserGroupPromotion::demoteUser()
     */
    public function demoteUser(array $promotion, $userId, $disablePromotion = false)
    {
        $db = $this->_getDb();
        XenForo_Db::beginTransaction($db);
        
        $promotionId = $promotion['promotion_id'];
        
        $this->_getUserModel()->removeUserGroupChange($userId, "ugPromotion$promotionId");
        
        $customFields = @unserialize($promotion['custom_fields_th']);
        if ($customFields) {
            foreach ($customFields as $customFieldId => $customFieldValue) {
                $this->_getUserChangeTempModel()->expireTempUserChangeByKey($userId, 
                    "ugPromotion$promotion[promotion_id]$customFieldId");
            }
        }
        
        if ($disablePromotion) {
            $this->insertPromotionLogEntry($promotionId, $userId, 'disabled');
        } else {
            // allow it to be re-added
            $db->delete('xf_user_group_promotion_log', 
                'promotion_id = ' . $db->quote($promotionId) . ' AND user_id = ' . $db->quote($userId));
        }
        
        XenForo_Db::commit($db);
    }

    /**
     *
     * @return XenForo_Model_UserChangeTemp
     */
    protected function _getUserChangeTempModel()
    {
        return $this->getModelFromCache('XenForo_Model_UserChangeTemp');
    }
}