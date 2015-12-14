<?php

class As_Custom_Model_Observer_Giftcard extends Mage_Core_Model_Abstract
{
    public function convertQuoteItemToOrderItem(Varien_Event_Observer $observer)
    {	
        $orderItem = $observer->getEvent()->getOrderItem();
        $quoteItem = $observer->getEvent()->getItem();
        $_product = $quoteItem->getProduct();

        if ($quoteItem->getProductType() != AW_Giftcard_Model_Catalog_Product_Type_Giftcard::TYPE_CODE) {
            return $this;
        }

        $giftCardOptions = array(
            'aw_gc_address1',
            'aw_gc_address2',
            'aw_gc_city',
            'aw_gc_country',
            'aw_gc_state',
            'aw_gc_zip',
            'aw_gc_telephone',
        );

        $productOptions = $orderItem->getProductOptions();
        foreach ($giftCardOptions as $_optionKey) {
            if ($option = $quoteItem->getProduct()->getCustomOption($_optionKey)) {
                $productOptions[$_optionKey] = $option->getValue();
            }
        }

        $orderItem->setProductOptions($productOptions);

        return $this;
    }

}
