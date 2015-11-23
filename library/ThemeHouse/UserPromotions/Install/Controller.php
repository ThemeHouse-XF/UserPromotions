<?php

class ThemeHouse_UserPromotions_Install_Controller extends ThemeHouse_Install
{

    protected $_resourceManagerUrl = 'https://xenforo.com/community/resources/user-promotions.4159/';

    protected $_minVersionId = 1020000;

    protected $_minVersionString = '1.2.0';

    protected function _getTableChanges()
    {
        return array(
            'xf_user_group_promotion' => array(
                'custom_fields_th' => 'mediumtext'
            )
        );
    }
}