<?php
class As_Brand_Model_Brand_Attribute_Source_Brand extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
    public function getAllOptions()
    {
        if (!$this->_options) {
				$this->_options[]=array('value' => '','label' => '');
				 
				$resource = Mage::getSingleton('core/resource');
				$adapter=$resource->getConnection('core_read');
				$table=$resource->getTableName('brand/brand');
				$select = $adapter->select()
					->from(array('brand_table' =>$table), array('*'))
					->where("brand_table.status = ?", 1);
				
				$rows=$adapter->fetchAll($select);
				
				foreach($rows as $row):
					 $this->_options[]=array('value' => $row['brand_id'],'label' => $row['title']);
				endforeach;
        }
        return $this->_options;
    }
}