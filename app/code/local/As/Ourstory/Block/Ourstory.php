<?php
class As_Ourstory_Block_Ourstory extends Mage_Core_Block_Template
{
     public function _prepareLayout()
     {
	return parent::_prepareLayout();
     }
    
     public function getOurstory()     
     { 
        $object =Mage::getModel('ourstory/ourstory')->load(1);
         return $object;
     }
     
     public function getVideo()     
     { 
       $object = Mage::getModel('ourstory/ourstory')->load(2);
        
       return $object;
     }
     
     public function getStaff()     
     { 
       $resource = Mage::getSingleton('core/resource');
       $read=$resource->getConnection('core_read');
       $table=$resource->getTableName('ourstory/staff');
       $select=$read->select()->from($table)->where('status=?',1);
       $rows=$read->fetchAll($select);
       return $rows;
     }
}
