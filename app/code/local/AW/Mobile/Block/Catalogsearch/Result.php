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
 

class AW_Mobile_Block_Catalogsearch_Result extends Mage_CatalogSearch_Block_Result
{
    /**
     * Helper
     * @return AW_Mobile_Helper_Data
     */
    public function _helper()
    {
        return Mage::helper('awmobile');
    }
        
    /**
     * Set search available list orders
     *
     * @return Mage_CatalogSearch_Block_Result
     */
    public function setListOrders()
    {
        parent::setListOrders();

        if (!$this->_helper()->checkVersion('1.4.0.0')
            && $this->getListBlock()
            && ($this->getListBlock()->getSortBy() == 'relevance')
        ) {
            $this->getListBlock()->setDefaultDirection('asc');
        }
        return $this;
    }
    
}