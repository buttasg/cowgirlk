<?php
class As_Custom_Model_Catalog_Product_Type_Giftcard extends AW_Giftcard_Model_Catalog_Product_Type_Giftcard
{
    const TYPE_CODE                = 'aw_giftcard';

    protected $_canUseQtyDecimals  = false;
    protected $_canConfigure       = true;

    public function getGiftcardTypeValue($product = null)
    {
         if (!Mage::app()->getStore()->isAdmin()) {
            $product = Mage::getModel('catalog/product')->load($product->getId());
        }
        $typeValue = $this->getProduct($product)->getAwGcType();
        return $typeValue;
    }

    public function isVirtual($product = null)
    {
        if ($this->isTypeVirtual($product)) {
            return true;
        }
        return false;
    }

    public function isTypeVirtual($product = null)
    {
        if ($this->getGiftcardTypeValue($product)
            == AW_Giftcard_Model_Source_Product_Attribute_Giftcard_Type::VIRTUAL_VALUE
        ) {
            return true;
        }
        return false;
    }

    public function isTypePhysical($product = null)
    {
        if ($this->getGiftcardTypeValue($product)
            == AW_Giftcard_Model_Source_Product_Attribute_Giftcard_Type::PHYSICAL_VALUE
        ) {
            return true;
        }
        return false;
    }

    public function isTypeCombined($product = null)
    {
        if ($this->getGiftcardTypeValue($product)
            == AW_Giftcard_Model_Source_Product_Attribute_Giftcard_Type::COMBINED_VALUE
        ) {
            return true;
        }
        return false;
    }

    public function isSalable($product = null)
    {
        $amountOptions = $this->getProduct($product)->getPriceModel()->getAmountOptions($product);
        $open = $this->getProduct($product)->getAwGcAllowOpenAmount();
        if (!$open && !$amountOptions) {
            return false;
        }
        return parent::isSalable($product);
    }

    public function prepareForCart(Varien_Object $buyRequest, $product = null)
    {
        if (!method_exists(get_parent_class($this), 'prepareForCartAdvanced')) {
            $result = parent::prepareForCart($buyRequest, $product);
            if (is_string($result)) {
                return $result;
            }
            $this->_prepareProduct($buyRequest, $product, null);
            return $result;
        }
        return parent::prepareForCart($buyRequest, $product);
    }

    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode)
    {
        $result = array();
        if (method_exists(get_parent_class($this), 'prepareForCartAdvanced')) {
            $result = parent::_prepareProduct($buyRequest, $product, $processMode);
            if (is_string($result)) {
                return $result;
            }
        }

        try {
            $amount = $this->_validateAndGetAmount($buyRequest, $product, $processMode);
        } catch (Mage_Core_Exception $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            Mage::logException($e);
            return Mage::helper('aw_giftcard')->__('An error has occurred while adding product to cart.');
        }

        $product->addCustomOption('aw_gc_amounts', $amount, $product);
        $product->addCustomOption('aw_gc_sender_name', $buyRequest->getAwGcSenderName(), $product);
        $product->addCustomOption('aw_gc_recipient_name', $buyRequest->getAwGcRecipientName(), $product);
	$product->addCustomOption('aw_gc_send_via', $buyRequest->getAwGcSendVia(), $product);
        if (!$this->isTypePhysical($product)) {
            $product->addCustomOption('aw_gc_sender_email', $buyRequest->getAwGcSenderEmail(), $product);
            $product->addCustomOption('aw_gc_recipient_email', $buyRequest->getAwGcRecipientEmail(), $product);
        }

        $messageAllowed = (bool) $product->getAwGcAllowMessage();
        if ($product->getAwGcConfigAllowMessage()) {
            $messageAllowed = (bool) Mage::helper('aw_giftcard/config')->isAllowGiftMessage();
        }

        if ($messageAllowed) {
            $product->addCustomOption('aw_gc_message', trim($buyRequest->getAwGcMessage()), $product);
        }
        
        
        if ($buyRequest->getAwGcSendVia()=="post")
        {
           $product->addCustomOption('aw_gc_address1', $buyRequest->getAwGcAddress1(), $product);
           $product->addCustomOption('aw_gc_address2', $buyRequest->getAwGcAddress2(), $product);
           $product->addCustomOption('aw_gc_city', $buyRequest->getAwGcCity(), $product);
           $product->addCustomOption('aw_gc_state', $buyRequest->getAwGcState(), $product);
           $product->addCustomOption('aw_gc_country', $buyRequest->getAwGcCountry(), $product);
           $product->addCustomOption('aw_gc_zip', $buyRequest->getAwGcZip(), $product);
           $product->addCustomOption('aw_gc_telephone', $buyRequest->getAwGcTelephone(), $product);
        
        }
        
        return $result;
    }

    private function _validateAndGetAmount(Varien_Object $buyRequest, $product, $processMode)
    {
        $product = $this->getProduct($product);
        $isStrictProcessMode = true;
        if (method_exists(get_parent_class($this), '_isStrictProcessMode')) {
            $isStrictProcessMode = $this->_isStrictProcessMode($processMode);
        }

        $allowedAmounts = array();
        $amountOptions = $product->getData('aw_gc_amounts');

        if (null === $amountOptions) {
            $amountOptions = $this->getProduct($product)->getPriceModel()->getAmountOptions($product);
        }

        foreach ($amountOptions as $value) {
            $allowedAmounts[] = Mage::app()->getStore()->roundPrice($value['value']);
        }

        $allowOpen = $product->getAwGcAllowOpenAmount();
        $minAmount = $product->getAwGcOpenAmountMin();
        $maxAmount = $product->getAwGcOpenAmountMax();

        $selectedAmountOption = $buyRequest->getData('aw_gc_amount');
        $customAmount = $buyRequest->getData('aw_gc_custom_amount');

        $rate = Mage::app()->getStore()->getCurrentCurrencyRate();
        if ($rate != 1 && $customAmount) {
            $customAmount = Mage::app()->getLocale()->getNumber($customAmount);
            if (is_numeric($customAmount) && $customAmount) {
                $customAmount = Mage::app()->getStore()->roundPrice($customAmount/$rate);
            }
        }

        $amount = null;

        if (($selectedAmountOption == 'custom' || !$selectedAmountOption) && $allowOpen) {
            if ($customAmount <= 0 && $isStrictProcessMode) {
                Mage::throwException(
                    Mage::helper('aw_giftcard')->__('Please specify Gift Card amount.')
                );
            }

            if (!$minAmount || ($minAmount && $customAmount >= $minAmount)) {
                if (!$maxAmount || ($maxAmount && $customAmount <= $maxAmount)) {
                    $amount = $customAmount;
                }

                if ($maxAmount && $customAmount > $maxAmount && $isStrictProcessMode) {
                    $messageAmount = Mage::helper('core')->currency($maxAmount, true, false);
                    Mage::throwException(
                        Mage::helper('aw_giftcard')->__('Maximum allowed Gift Card amount is %s', $messageAmount)
                    );
                }
            }

            if ($minAmount && $customAmount < $minAmount && $isStrictProcessMode) {
                $messageAmount = Mage::helper('core')->currency($minAmount, true, false);
                Mage::throwException(
                    Mage::helper('aw_giftcard')->__('Minimum allowed Gift Card amount is %s', $messageAmount)
                );
            }
        }

        if (is_numeric($selectedAmountOption) && in_array($selectedAmountOption, $allowedAmounts)) {
            $amount = $selectedAmountOption;
        }

        if (is_null($amount) && count($allowedAmounts) == 1) {
            $amount = array_shift($allowedAmounts);
        }

        if (is_null($amount) && $this->getProduct($product)->getCustomOption('aw_gc_amounts')) {
            $amount = $this->getProduct($product)->getCustomOption('aw_gc_amounts')->getValue();
        }

        if (is_null($amount) && $isStrictProcessMode) {
            Mage::throwException(
                Mage::helper('aw_giftcard')->__('Please specify Gift Card amount.')
            );
        }
        $this->_validateBuyRequest($buyRequest, $product, $processMode);

        return $amount;
    }

    protected function _validateBuyRequest(Varien_Object $buyRequest, $product, $processMode)
    {
        $isStrictProcessMode = true;
        if (method_exists(get_parent_class($this), '_isStrictProcessMode')) {
            $isStrictProcessMode = $this->_isStrictProcessMode($processMode);
        }

        if (!$buyRequest->getAwGcRecipientName() && $isStrictProcessMode) {
            Mage::throwException(
                Mage::helper('aw_giftcard')->__('Please specify recipient name.')
            );
            return false;
        }
        if (!$buyRequest->getAwGcSenderName() && $isStrictProcessMode) {
            Mage::throwException(
                Mage::helper('aw_giftcard')->__('Please specify sender name.')
            );
            return false;
        }

        if ($this->isTypeVirtual($product) || $this->isTypeCombined($product)) {
            if (!$buyRequest->getAwGcRecipientEmail() && $isStrictProcessMode) {
                Mage::throwException(
                    Mage::helper('aw_giftcard')->__('Please specify recipient email.')
                );
                return false;
            }
            if (!$buyRequest->getAwGcSenderEmail() && $isStrictProcessMode) {
                Mage::throwException(
                    Mage::helper('aw_giftcard')->__('Please specify sender email.')
                );
                return false;
            }
        }
        
        
         if (!$buyRequest->getAwGcSendVia() && $isStrictProcessMode) {
            Mage::throwException(
                Mage::helper('aw_giftcard')->__('Please specify gift card sending medium.')
            );
            return false;
        }
        
        
        if ($buyRequest->getAwGcSendVia()=="post") 
        {
            
            if(!$buyRequest->getAwGcAddress1())
            {
		Mage::throwException(
		        Mage::helper('aw_giftcard')->__('Please specify address line 1.')
		 );
		 return false;
            }
            
            /*if(!$buyRequest->getAwGcAddress2())
            {
		Mage::throwException(
		        Mage::helper('aw_giftcard')->__('Please specify address line 2.')
		 );
		 return false;
            }*/
            
            
            if(!$buyRequest->getAwGcCity())
            {
		Mage::throwException(
		        Mage::helper('aw_giftcard')->__('Please specify city.')
		 );
		 return false;
            }
            
             if(!$buyRequest->getAwGcCountry())
            {
		Mage::throwException(
		        Mage::helper('aw_giftcard')->__('Please specify country.')
		 );
		 return false;
            }
            
            
             if(!$buyRequest->getAwGcState())
            {
		Mage::throwException(
		        Mage::helper('aw_giftcard')->__('Please specify state.')
		 );
		 return false;
            }
            
             if(!$buyRequest->getAwGcZip())
            {
		Mage::throwException(
		        Mage::helper('aw_giftcard')->__('Please specify zip.')
		 );
		 return false;
            }
            
            if(!$buyRequest->getAwGcTelephone())
            {
		Mage::throwException(
		        Mage::helper('aw_giftcard')->__('Please specify telephone.')
		 );
		 return false;
            }
            
            
        }
        
        
        
        
        
        return true;
    }

    public function checkProductBuyState($product = null)
    {
        parent::checkProductBuyState($product);
        $product = $this->getProduct($product);
        $option = $product->getCustomOption('info_buyRequest');
        if ($option instanceof Mage_Sales_Model_Quote_Item_Option) {
            $buyRequest = new Varien_Object(unserialize($option->getValue()));
            $mode = true;
            if (defined('Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL')) {
                $mode = Mage_Catalog_Model_Product_Type_Abstract::PROCESS_MODE_FULL;
            }
            $this->_validateAndGetAmount($buyRequest, $product, $mode);
        }
        return $this;
    }

    public function beforeSave($product = null)
    {
        parent::beforeSave($product);
        $this->getProduct($product)->setTypeHasOptions(true);
        $this->getProduct($product)->setTypeHasRequiredOptions(true);
        return $this;
    }

    public function processBuyRequest($product, $buyRequest)
    {
        $options = array(
            'aw_gc_amounts'         => $buyRequest->getAwGcAmount(),
            'aw_gc_custom_amount'   => $buyRequest->getAwGcCustomAmount(),
            'aw_gc_sender_name'     => $buyRequest->getAwGcSenderName(),
            'aw_gc_sender_email'    => $buyRequest->getAwGcSenderEmail(),
            'aw_gc_recipient_name'  => $buyRequest->getAwGcRecipientName(),
            'aw_gc_recipient_email' => $buyRequest->getAwGcRecipientEmail(),
            'aw_gc_message'         => $buyRequest->getAwGcMessage()
        );
        return $options;
    }

    public function hasOptions($product = null)
    {
        if ($this->getProduct($product)->getOptions()
            || !Mage::registry('current_product')
            || AW_All_Helper_Versions::getPlatform() == AW_All_Helper_Versions::EE_PLATFORM
        ) {
            return true;
        }
        return false;
    }
}
