<?php
class As_Brand_Block_Brand extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {	
		
		return parent::_prepareLayout();
    }
    
     public function getBrand()     
     { 
        if (!$this->hasData('brand')) {
            $this->setData('brand', Mage::registry('brand'));
        }
        return $this->getData('brand');
        
    }
	
	public function getBrands()
	{
            $resource = Mage::getSingleton('core/resource');
            $read= $resource->getConnection('core_read');
            $brandTable = $resource->getTableName('brand');

            $select = $read->select()
               ->from($brandTable,array('*'))
               ->where('status=?',1)
               ->order('title') ;

            $brands = $read->fetchAll($select);
            return $brands;
	}
}
