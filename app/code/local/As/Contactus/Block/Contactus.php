<?php
class As_Contactus_Block_Contactus extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getContactus()     
     { 
        if (!$this->hasData('contactus')) {
            $this->setData('contactus', Mage::registry('contactus'));
        }
        return $this->getData('contactus');
        
    }
}