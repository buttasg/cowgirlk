<?php
class As_Account_Block_Account extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAccount()     
     { 
        if (!$this->hasData('account')) {
            $this->setData('account', Mage::registry('account'));
        }
        return $this->getData('account');
        
    }
}