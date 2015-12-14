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
 * @package    AW_Giftcard
 * @version    1.0.6
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */

class AW_Giftcard_Block_Adminhtml_Sales_Items_Column_Name_Giftcard extends Mage_Adminhtml_Block_Sales_Items_Column_Name
{
    protected function _getPreparedCustomOptionByCode($code)
    {
        $item = $this->getItem();
        $option = $item->getProductOptionByCode($code);
        if ($option) {
            return $this->escapeHtml($option);
        }
        return false;
    }

    protected function _getGiftcardOptions()
    {	
        $senderName     = $this->_getPreparedCustomOptionByCode('aw_gc_sender_name');
        $senderEmail    = $this->_getPreparedCustomOptionByCode('aw_gc_sender_email');
        $recipientName  = $this->_getPreparedCustomOptionByCode('aw_gc_recipient_name');
        $recipientEmail = $this->_getPreparedCustomOptionByCode('aw_gc_recipient_email');
        $message        = $this->_getPreparedCustomOptionByCode('aw_gc_message');
        $type           = $this->_getPreparedCustomOptionByCode('aw_gc_type');
        $giftCards      = $this->_getPreparedCustomOptionByCode('aw_gc_created_codes');
        $isEmailSent    = $this->_getPreparedCustomOptionByCode('email_sent');
        ########
        $item = $this->getItem();
        $buyInfo = $item->getBuyRequest();
        $sendVia    =$buyInfo->getData('aw_gc_send_via');
        
        if($sendVia=='email'){
        $result[] = array(
                'label' => $this->__('Send Via'),
                'value' => $buyInfo->getData('aw_gc_send_via')
            );
	}
	
	
	if($sendVia=='post'){
           $result[] = array(
                'label' => $this->__('Send Via'),
                'value' => $buyInfo->getData('aw_gc_send_via')
            );
           
            $address= array();
            $address[]=$buyInfo->getData('aw_gc_address1');
            $address[]=$buyInfo->getData('aw_gc_address2');
            $address[]=$buyInfo->getData('aw_gc_city');
            $address[]=$buyInfo->getData('aw_gc_country');
            $address[]=$buyInfo->getData('aw_gc_state');
            $address[]=$buyInfo->getData('aw_gc_zip');
            $address[]=$buyInfo->getData('aw_gc_telephone');
            $result[] = array(
                'label' => $this->__('Post Address'),
                'value' => implode("\n", $address)
            );
            
	}
	############
        if ($type) {
            $result[] = array(
                'label' => $this->__('Gift Card Type'),
                'value' => Mage::getModel('aw_giftcard/source_product_attribute_giftcard_type')->getOptionText($type)
            );
        }

        if ($senderName) {
            $senderOptionText = $senderName;
            if ($senderEmail) {
                $senderOptionText = "{$senderName} &lt;{$senderEmail}&gt;";
            }
            $result[] = array(
                'label' => $this->__('Gift Card Sender'),
                'value' => $senderOptionText
            );
        }

        if ($recipientName) {
            $recipientOptionText = $recipientName;
            if ($recipientEmail) {
                $recipientOptionText = "{$recipientName} &lt;{$recipientEmail}&gt;";
            }

            $result[] = array(
                'label' => $this->__('Gift Card Recipient'),
                'value' => $recipientOptionText
            );

            if (!$isEmailSent) {
                $isEmailSent = AW_Giftcard_Model_Source_Product_Attribute_Option_Yesno::DISABLED_LABEL;
            }

            $result[] = array(
                'label' => $this->__('Email Sent'),
                'value' => $isEmailSent
            );
        }

        if (trim($message)) {
            $result[] = array(
                'label' => $this->__('Gift Card Message'),
                'value' => $message
            );
        }

        $_codes = array($this->__('N/A'));
        if ($giftCards) {
            $_codes = $giftCards;
        }

        $result[] = array(
            'label' => $this->__('Gift Card Codes'),
            'value' => implode('<br />', $_codes)
        );
        return $result;
    }

    public function getOrderOptions()
    {
        return array_merge($this->_getGiftcardOptions(), parent::getOrderOptions());
    }
}
