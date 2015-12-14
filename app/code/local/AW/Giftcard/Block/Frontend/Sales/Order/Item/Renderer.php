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

class AW_Giftcard_Block_Frontend_Sales_Order_Item_Renderer extends Mage_Sales_Block_Order_Item_Renderer_Default
{
    protected function _getPreparedCustomOptionByCode($code)
    {
        $item = $this->getOrderItem();
        $option = $item->getProductOptionByCode($code);
        if ($option) {
            return $this->escapeHtml($option);
        }
        return false;
    }

    protected function _getGiftcardOptions($useQuote = true)
    {
        $senderName     = $this->_getPreparedCustomOptionByCode('aw_gc_sender_name');
        $senderEmail    = $this->_getPreparedCustomOptionByCode('aw_gc_sender_email');
        $recipientName  = $this->_getPreparedCustomOptionByCode('aw_gc_recipient_name');
        $recipientEmail = $this->_getPreparedCustomOptionByCode('aw_gc_recipient_email');
        $message        = $this->_getPreparedCustomOptionByCode('aw_gc_message');
        $result = array();
        
        
        ###########
        $item = $this->getOrderItem();
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
        
        
        if ($senderName) {
            $senderOptionText = $senderName;
            if ($senderEmail) {
                $senderOptionText = "{$senderName} &lt;{$senderEmail}&gt;";
                if (!$useQuote) {
                    $senderOptionText = "{$senderName} <{$senderEmail}>";
                }
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
                if (!$useQuote) {
                    $recipientOptionText = "{$recipientName} <{$recipientEmail}>";
                }
            }
            $result[] = array(
                'label' => $this->__('Gift Card Recipient'),
                'value' => $recipientOptionText
            );
        }

        if (trim($message)) {
            $result[] = array(
                'label' => $this->__('Gift Card Message'),
                'value' => $message
            );
        }
        return $result;
    }

    public function getItemOptions()
    {
        return array_merge($this->_getGiftcardOptions(), parent::getItemOptions());
    }
}
