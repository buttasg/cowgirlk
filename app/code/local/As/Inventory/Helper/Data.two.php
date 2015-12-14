<?php

class As_Inventory_Helper_Data extends Mage_Core_Helper_Abstract
{	
	
	public function getAttributes()     
    { 
        if (!Mage::registry('inventory_attr')) {
			$read = Mage::getSingleton("core/resource")->getConnection("core_read"); 
			$select = $read->select()->from(array("a" => "eav_attribute"), 
					array("attribute_id", "attribute_code", "frontend_label"))
					->join(array("ao" => "eav_attribute_option"), "a.attribute_id = ao.attribute_id AND a.entity_type_id=4  AND a.is_user_defined=1 AND a.frontend_input='select'", array())
					->order("frontend_label")->group('a.attribute_id');
			$data= $read->fetchAll ($select);
			Mage::register('inventory_attr',$data);
        }
        return Mage::registry('inventory_attr');
        
    }

	public function getPreparedCollection($dropship=false)
	{	$attributeModel = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'cost');
		$costId=$attributeModel->getAttributeId();
		//print_r($attributeModel); die();
		if (!Mage::registry('inventory_collection')) 
		{ 
			//$collection = Mage::getModel('catalog/product')->getCollection()
			$collection = Mage::getResourceModel('catalog/product_collection')
						->addAttributeToSelect('sku')
						->addAttributeToSelect('name')
						->addAttributeToSelect('attribute_set_id')
						->addAttributeToSelect('type_id')
						->joinField('qty',
						'cataloginventory/stock_item',
						'qty',
						'product_id=entity_id',
						'{{table}}.stock_id=1',
						'left');
				   $countSelect =  $collection->getSelect();

				   $attributes=$this->getAttributes();
				   foreach($attributes as $row)
				   {	
						$id =$row['attribute_id'];
						$code=$row['attribute_code'];
						$tableName='at_'.$code;
						$table=array($tableName=>'catalog_product_entity_int');
						$countSelect->joinLeft($table, $tableName.'.entity_id = e.entity_id AND '.$tableName.'.attribute_id='.$id,array($code=>$tableName.'.value'));
						
						$textTableName='txt_'.$code;
						$textTable=array($textTableName=>'eav_attribute_option_value');
						$countSelect->joinLeft($textTable, $textTableName.'.option_id = '.$tableName.'.value',array($textTableName=>$textTableName.'.value'));
				   }
		    		  $id =$costId;
		     	          $code='cost';
				  $tableName='at_'.$code;
				  $table=array($tableName=>'catalog_product_entity_decimal');
				  $countSelect->joinLeft($table, $tableName.'.entity_id = e.entity_id  AND '.$tableName.'.attribute_id='.$id ,array($code=>$tableName.'.value'));
				  
				  $countSelect->columns('(at_qty.qty*at_cost.value) as total_cost');
				  
				  if($dropship){
				  	$countSelect->where("at_cost.value<=0 OR at_cost.value='' OR at_cost.value IS NULL");
				  	
				  }
				  else
				  {
				  	$countSelect->where('at_cost.value>?','0');
				  	
				  }
				 //echo $countSelect;
				 //return $collection;
			Mage::register('inventory_collection',$collection);
        	}
        
        
        	return Mage::registry('inventory_collection');
	
	}
}
