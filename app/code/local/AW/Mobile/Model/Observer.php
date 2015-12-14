<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Mobile
 * @version    1.6.7
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


/**
 * Predispatch observer
 */
class AW_Mobile_Model_Observer
{
    /**
     * Mobile redirect YES/NO
     */

    const MOBILE_REDIRECT = 'awmobile/behaviour/mobile_redirect';

    /**
     * Store which will mobile redirect
     */

    const MOBILE_REDIRECT_TO = 'awmobile/behaviour/redirect_to';

    /**
     * Trget is Desktop
     */

    const TARGET_DESKTOP = 'desktop';

    /**
     * Target is Mobile
     */
    const TARGET_MOBILE = 'mobile';


    const MOBILE_COOKIE = 'aw_mobile_cookie';
    /**
     * Merge JS config path
     */
    const XML_PATH_MERGE_JS = 'dev/js/merge_files';
    const COOKIE_NAME = 'iphone_store';
    const LOGOUT_FORCED_REDIRECT = 'awmobile_force_switch';

    /**
     * Params to change in config
     *
     * @var array
     */
    protected $_initParams = array('layout', 'template', 'skin');

    /**
     * Retrives data helper
     *
     * @return AW_Mobile_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('awmobile');
    }

    /**
     * retrives singleton instance of Design Package
     *
     * @return AW_Mobile_Model_Core_Design_Package
     */
    protected function _getDesignPackage()
    {
        return Mage::getSingleton('core/design_package');
    }

    /**
     * Initialize mobile theme on fly
     *
     * @return AW_Mobile_Model_Observer
     */
    protected function _initMobile()
    {
        Varien_Profiler::start('aw::mobile::init_mobile');
        $this->_getDesignPackage()->setPackageName($this->_helper()->getMobilePackage());
        foreach ($this->_initParams as $type) {
//            Mage::app()->getStore()->setConfig('design/theme/'.$type, $this->_mobileVal);
            $this->_getDesignPackage()->setTheme($this->_helper()->getMobileTheme());
        }

        if (version_compare(Mage::getVersion(), '1.9.1.0', '>=')) {
            $this->_saveOption('awmobile/compatibility/is_1910', 1);
            $this->_saveOption('awmobile/compatibility/is_not_1910', 0);
        } else {
            $this->_saveOption('awmobile/compatibility/is_1910', 0);
            $this->_saveOption('awmobile/compatibility/is_not_1910', 1);
        }

        Varien_Profiler::stop('aw::mobile::init_mobile');
        return $this;
    }

    /**
     * Check initiallized mobile theme
     *
     * @return boolean
     */
    protected function _checkMobile()
    {
        $result = true;
        foreach ($this->_initParams as $type) {
            if (Mage::app()->getStore()->getConfig('design/theme/' . $type) != $this->_mobileVal) {
                $result = false;
            }
        }
        return $result;
    }

    protected function _registerMobilePageConfig()
    {
        if (!Mage::registry('_singleton/page/config')) {
            Mage::register('_singleton/page/config', Mage::getModel('awmobile/page_config'));
        }
    }

    public function predispatch($event)
    {
        if ($this->getCookie()->get(self::LOGOUT_FORCED_REDIRECT)) {
            $this->getCookie()->delete(self::LOGOUT_FORCED_REDIRECT);
            Mage::helper('awmobile')->setShowDesktop(false);
            return Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/logoutSuccess'));
        }
        if (Mage::getConfig()->getNode('modules/Enterprise_Enterprise')) {
            if ($this->_helper()->getTargetPlatform() == self::TARGET_MOBILE) {
                $customDesign = Mage::getStoreConfig(AW_Mobile_Helper_Data::XML_PATH_MOBILE_CUSTOM_THEME);
                if (!$customDesign) {
                    $packageName = Mage::helper('awmobile')->getMobilePackage();
                    $themeName = Mage::helper('awmobile')->getMobileTheme();
                } else {
                    $customDesign = explode('/', $customDesign);
                    $packageName = $customDesign[0];
                    $themeName = $customDesign[1];
                }
            } else {
                Mage::getDesign()->setPackageName('aw_iphone_force_check');
                $packageName = Mage::getDesign()->getPackageName();
                $themeName = Mage::getDesign()->getTheme('');
            }

            $rewriteCookie = "{$packageName}_{$themeName}";
            $this->getCookie()->delete(self::MOBILE_COOKIE);
            $this->getCookie()->set(self::MOBILE_COOKIE, $rewriteCookie, true, '/');
        }


        if (Mage::getDesign()->getArea() == 'adminhtml') {
            return $this;
        }


        if ($this->_helper()->getTargetPlatform() == self::TARGET_MOBILE) {
            if (
                !Mage::helper('awmobile')->isForced()
                && Mage::getStoreConfig(self::MOBILE_REDIRECT, Mage::app()->getStore()->getId())
                && Mage::getStoreConfig(
                    self::MOBILE_REDIRECT_TO, Mage::app()->getStore()->getId()
                )
            ) {
                Mage::helper('awmobile')->setFromStore();
                $controllerAction = $event->getControllerAction();
                $controllerAction->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                Mage::app()->getFrontController()->getResponse()->setRedirect(
                    Mage::app()->getStore(
                        Mage::getStoreConfig(self::MOBILE_REDIRECT_TO, Mage::app()->getStore()->getId())
                    )->getBaseUrl('direct_link') . "?___store=" . Mage::app()->getStore(
                        Mage::getStoreConfig(self::MOBILE_REDIRECT_TO, Mage::app()->getStore()->getId())
                    )->getCode() . "&___from=" . Mage::app()->getStore()->getCode()
                )->sendResponse();
                exit;
            }
            $request = Mage::app()->getFrontController()->getRequest();

            if ($request->getActionName() == 'index' && $request->getControllerName() == 'cart') {
                $controllerAction = $event->getControllerAction();
                $controllerAction->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                return Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getBaseUrl() . '#cart');
            }
            $this->_registerMobilePageConfig();
            $this->_initMobile();
        }
        return $this;
    }

    public function getCookie()
    {
        return Mage::getSingleton('core/cookie');
    }

    protected function _saveOption($path, $value)
    {
        if (is_null(Mage::getStoreConfig($path)) || (Mage::getStoreConfig($path) !== $value)) {
            Mage::app()->getConfig()->saveConfig($path, $value);
        }
    }

    public function beforeFrontendInit($event)
    {
        Varien_Profiler::start('aw::mobile::frontend_init');
        if ($this->_helper()->isPageCache()) {
            $tags = Mage::app()->useCache();
            $tags['full_page'] = 0;
            Mage::app()->saveUseCache($tags);
        }

        if (Mage::getStoreConfig(self::XML_PATH_MERGE_JS)) {
            if (version_compare(Mage::getVersion(), '1.3.3.0', '<=')) {
                Mage::app()->getConfig()->saveConfig(self::XML_PATH_MERGE_JS, 0);
            }
        }
        Varien_Profiler::stop('aw::mobile::frontend_init');
    }

    public function customerLogout()
    {
        if ($this->_helper()->getTargetPlatform() == self::TARGET_MOBILE && Mage::helper('awmobile')->isForced()) {
            $this->getCookie()->set(self::LOGOUT_FORCED_REDIRECT, 1);
        }
        return $this;
    }
}