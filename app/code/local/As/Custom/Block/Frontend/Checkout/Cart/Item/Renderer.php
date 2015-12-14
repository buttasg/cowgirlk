<?php

class As_Custom_Block_Frontend_Checkout_Cart_Item_Renderer extends AW_Giftcard_Block_Frontend_Checkout_Cart_Item_Renderer
{
    protected function _getGiftcardOptions()
    {
        $senderName     = $this->_getPreparedCustomOptionByCode('aw_gc_sender_name');
        $senderEmail    = $this->_getPreparedCustomOptionByCode('aw_gc_sender_email');
        $recipientName  = $this->_getPreparedCustomOptionByCode('aw_gc_recipient_name');
        $recipientEmail = $this->_getPreparedCustomOptionByCode('aw_gc_recipient_email');
        $message        = $this->_getPreparedCustomOptionByCode('aw_gc_message');
	
	
	$sendVia       = $this->_getPreparedCustomOptionByCode('aw_gc_send_via');
	
        $result = array();
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
        }

        if (trim($message)) {
            $result[] = array(
                'label' => $this->__('Gift Card Message'),
                'value' => $message
            );
        }
        
        if (trim($sendVia)) {
            $result[] = array(
                'label' => $this->__('Send Via'),
                'value' => $sendVia
            );
        }
        
        return $result;
    }

    public function getOptionList()
    {
        return array_merge(
            $this->_getGiftcardOptions(),
            parent::getOptionList()
        );
    }

    protected function _getPreparedCustomOptionByCode($code)
    {
        $item = $this->getItem();

        $option = $item->getOptionByCode($code);
        if ($option) {
            $value = $option->getValue();
            if ($value) {
                return $this->escapeHtml($value);
            }
        }
        return false;
    }
}
