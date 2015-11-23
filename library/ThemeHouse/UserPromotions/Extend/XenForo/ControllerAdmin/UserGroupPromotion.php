<?php

/**
 *
 * @see XenForo_ControllerAdmin_UserGroupPromotion
 */
class ThemeHouse_UserPromotions_Extend_XenForo_ControllerAdmin_UserGroupPromotion extends XFCP_ThemeHouse_UserPromotions_Extend_XenForo_ControllerAdmin_UserGroupPromotion
{

    /**
     *
     * @see XenForo_ControllerAdmin_UserGroupPromotion::actionIndex()
     */
    public function actionIndex()
    {
        $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('user-promotions'));
        
        return parent::actionIndex();
    }

    /**
     *
     * @see XenForo_ControllerAdmin_UserGroupPromotion::_getPromotionAddEditResponse()
     */
    protected function _getPromotionAddEditResponse(array $promotion)
    {
        $response = parent::_getPromotionAddEditResponse($promotion);
        
        if ($response instanceof XenForo_ControllerResponse_View) {
            $promotion = $response->params['promotion'];
            
            if (!empty($promotion['promotion_id'])) {
                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('user-promotions/edit', $promotion));
            } else {
                $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('user-promotions/add'));
            }
            
            $customFields = @unserialize($promotion['custom_fields_th']);
            
            if (!$customFields) {
                $customFields = array();
            }
            
            $response->params['customFields'] = $customFields;
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_UserGroupPromotion::actionSave()
     */
    public function actionSave()
    {
        $GLOBALS['XenForo_ControllerAdmin_UserGroupPromotion'] = $this;
        
        return parent::actionSave();
    }

    /**
     *
     * @see XenForo_ControllerAdmin_UserGroupPromotion::actionDelete()
     */
    public function actionDelete()
    {
        $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('user-promotions/delete'));
        
        $response = parent::actionDelete();
        
        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $response->redirectTarget = XenForo_Link::buildAdminLink('user-promotions');
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_UserGroupPromotion::actionHistory()
     */
    public function actionHistory()
    {
        $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('user-promotions/history'));
        
        return parent::actionHistory();
    }

    /**
     *
     * @see XenForo_ControllerAdmin_UserGroupPromotion::actionManual()
     */
    public function actionManual()
    {
        $response = parent::actionManual();
        
        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $response->redirectTarget = XenForo_Link::buildAdminLink('user-promotions/manage');
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerAdmin_UserGroupPromotion::actionToggle()
     */
    public function actionToggle()
    {
        $this->canonicalizeRequestUrl(XenForo_Link::buildAdminLink('user-promotions/toggle'));
        
        $response = parent::actionToggle();
        
        if ($response instanceof XenForo_ControllerResponse_Redirect) {
            $response->redirectTarget = XenForo_Link::buildAdminLink('user-promotions');
        }
        
        return $response;
    }
}