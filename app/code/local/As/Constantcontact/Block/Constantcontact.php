<?php
class As_Constantcontact_Block_Constantcontact extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getConstantcontact()     
     { 
        if (!$this->hasData('constantcontact')) {
            $this->setData('constantcontact', Mage::registry('constantcontact'));
        }
        return $this->getData('constantcontact');
        
    }
}