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


include_once '__cms.php';
class AW_Mobile_Model_Page_Config extends Mage_Page_Model_Config
{

    /**
     * Initialize page layouts list
     *
     * @return Mage_Page_Model_Config
     */
    protected function _initPageLayouts()
    {
        parent::_initPageLayouts();
        foreach ($this->_pageLayouts as $layout) {
            $layout->setTemplate('page/1column.phtml');
        }
        return $this;
    }
}
