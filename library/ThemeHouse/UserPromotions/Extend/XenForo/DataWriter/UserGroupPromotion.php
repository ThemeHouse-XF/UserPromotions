<?php

/**
 *
 * @see XenForo_DataWriter_UserGroupPromotion
 */
class ThemeHouse_UserPromotions_Extend_XenForo_DataWriter_UserGroupPromotion extends XFCP_ThemeHouse_UserPromotions_Extend_XenForo_DataWriter_UserGroupPromotion
{

    /**
     *
     * @see XenForo_DataWriter_UserGroupPromotion::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();
        
        unset($fields['xf_user_group_promotion']['extra_user_group_ids']['required']);
        unset($fields['xf_user_group_promotion']['extra_user_group_ids']['requiredError']);
        $fields['xf_user_group_promotion']['extra_user_group_ids']['default'] = '';
        
        $fields['xf_user_group_promotion']['custom_fields_th'] = array(
            'type' => self::TYPE_SERIALIZED,
            'default' => ''
        );
        
        return $fields;
    }

    /**
     *
     * @see XenForo_DataWriter_UserGroupPromotion::_preSave()
     */
    protected function _preSave()
    {
        parent::_preSave();
        
        if (isset($GLOBALS['XenForo_ControllerAdmin_UserGroupPromotion'])) {
            /* @var $controller XenForo_ControllerAdmin_UserGroupPromotion */
            $controller = $GLOBALS['XenForo_ControllerAdmin_UserGroupPromotion'];
            
            $input = $controller->getInput()->filter(
                array(
                    'custom_fields' => XenForo_Input::ARRAY_SIMPLE,
                    'custom_fields_shown' => XenForo_Input::UINT
                ));
            
            if ($input['custom_fields_shown']) {
                $this->set('custom_fields_th', $input['custom_fields']);
            }
        }
    }
}