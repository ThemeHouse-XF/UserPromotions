<?php

class ThemeHouse_UserPromotions_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_UserPromotions' => array(
                'route_prefix' => array(
                    'XenForo_Route_PrefixAdmin_UserGroupPromotions'
                ),
                'datawriter' => array(
                    'XenForo_DataWriter_UserGroupPromotion'
                ),
                'deferred' => array(
                    'XenForo_Deferred_UserGroupPromotion'
                ),
                'model' => array(
                    'XenForo_Model_AdminNavigation',
                    'XenForo_Model_UserGroupPromotion',
                    'XenForo_Model_UserChangeTemp'
                ),
                'controller' => array(
                    'XenForo_ControllerAdmin_UserGroupPromotion'
                ),
            ),
        );
    }

    public static function loadClassRoutePrefix($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_UserPromotions_Listener_LoadClass', $class, $extend, 'route_prefix');
    }

    public static function loadClassDataWriter($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_UserPromotions_Listener_LoadClass', $class, $extend, 'datawriter');
    }

    public static function loadClassDeferred($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_UserPromotions_Listener_LoadClass', $class, $extend, 'deferred');
    }

    public static function loadClassModel($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_UserPromotions_Listener_LoadClass', $class, $extend, 'model');
    }

    public static function loadClassController($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_UserPromotions_Listener_LoadClass', $class, $extend, 'controller');
    }
}