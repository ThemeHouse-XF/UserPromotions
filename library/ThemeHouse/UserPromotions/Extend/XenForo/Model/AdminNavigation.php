<?php

/**
 *
 * @see XenForo_Model_AdminNavigation
 */
class ThemeHouse_UserPromotions_Extend_XenForo_Model_AdminNavigation extends XFCP_ThemeHouse_UserPromotions_Extend_XenForo_Model_AdminNavigation
{

    public function filterUnviewableAdminNavigation(array $navigation)
    {
        unset($navigation['userGroupPromotions']);
        
        return parent::filterUnviewableAdminNavigation($navigation);
    }
}