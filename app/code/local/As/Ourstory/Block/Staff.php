<?php
class As_Ourstory_Block_Staff extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getOurstory()     
     { 
        if (!$this->hasData('staff')) {
            $this->setData('staff', Mage::registry('staff'));
        }
        return $this->getData('staff');
        
    }
}