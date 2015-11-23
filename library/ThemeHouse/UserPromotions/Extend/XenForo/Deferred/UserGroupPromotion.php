<?php

/**
 *
 * @see XenForo_Deferred_UserGroupPromotion
 */
class ThemeHouse_UserPromotions_Extend_XenForo_Deferred_UserGroupPromotion extends XFCP_ThemeHouse_UserPromotions_Extend_XenForo_Deferred_UserGroupPromotion
{

    public function execute(array $deferred, array $data, $targetRunTime, &$status)
    {
        $data = parent::execute($deferred, $data, $targetRunTime, $status);
        
        $actionPhrase = new XenForo_Phrase('rebuilding');
        $typePhrase = new XenForo_Phrase('th_user_promotions_userpromotions');
        $status = sprintf('%s... %s (%s)', $actionPhrase, $typePhrase, XenForo_Locale::numberFormat($data['position']));
        
        return $data;
    }
}