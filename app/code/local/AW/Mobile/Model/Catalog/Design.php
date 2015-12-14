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


class AW_Mobile_Model_Catalog_Design extends Mage_Catalog_Model_Design
{
    /**
     * Apply package and theme
     *
     * @param string $package
     * @param string $theme
     *
     * @return $this
     */
    protected function _apply($package, $theme)
    {
        if (Mage::helper('awmobile')->getTargetPlatform() != AW_Mobile_Model_Observer::TARGET_MOBILE) {
            parent::_apply($package, $theme);
            return $this;
        }
        return $this;
    }            
}