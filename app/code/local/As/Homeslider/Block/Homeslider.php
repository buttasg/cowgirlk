<?php
class As_Homeslider_Block_Homeslider extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getHomeslides()     
     { 
        $resource = Mage::getSingleton('core/resource');
	$read= $resource->getConnection('core_read');
	$homesliderTable = $resource->getTableName('homeslider');
	$homeslider =NULL;
	$select = $read->select()
                       ->from($homesliderTable,array('*'))->order(array('position ASC'))
			   ->where('status=?',1);		   
	$homeslider = $read->fetchAll($select);
        return $homeslider;
        
    }
}
