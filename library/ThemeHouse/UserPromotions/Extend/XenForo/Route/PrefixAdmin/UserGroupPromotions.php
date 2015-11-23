<?php

/**
 *
 * @see XenForo_Route_PrefixAdmin_UserGroupPromotions
 */
class ThemeHouse_UserPromotions_Extend_XenForo_Route_PrefixAdmin_UserGroupPromotions extends XFCP_ThemeHouse_UserPromotions_Extend_XenForo_Route_PrefixAdmin_UserGroupPromotions
{

    /**
     *
     * @see XenForo_Route_PrefixAdmin_UserGroupPromotions::match()
     */
    public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
    {
        /* @var $match XenForo_RouteMatch */
        $match = parent::match($routePath, $request, $router);
        
        $match->setSections('userPromotions');
        
        return $match;
    }

    /**
     * Method to build a link to the specified page/action with the provided
     * data and params.
     *
     * @see XenForo_Route_BuilderInterface
     */
    public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
    {
        if ($originalPrefix == 'user-group-promotions') {
            $outputPrefix = 'user-promotions';
        }
        
        return parent::buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, $extraParams);
    }
}