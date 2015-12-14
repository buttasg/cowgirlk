<?php
class As_Custom_Model_Observer_Comment extends Mage_Core_Model_Abstract
{
    public function saveOrder($evt)
    {
      $_order   = $evt->getOrder();
      $_request = Mage::app()->getRequest();
 
      $_comments = strip_tags($_request->getParam('order_comment'));
 
      if(!empty($_comments)){
        $_comments = 'Additional Order Comments: ' . $_comments;
        $_order->setCustomerNote($_comments);
      }
 
      return $this;
    }

}
