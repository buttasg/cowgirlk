<?php

class As_Inventory_Block_Adminhtml_Inventory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('inventoryGrid');
      $this->setDefaultSort('inventory_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {   //$resource=Mage::getSingleton('core/resource');
      
      
      $collection =  Mage::getModel('catalog/product')->getCollection()
      		    /*->addAttributeToSelect('entity_id')
                    ->addAttributeToSelect('name')
                    ->addAttributeToSelect('sku')
                    ->addAttributeToSelect('color')
                    ->addAttributeToSelect('gerneral_size')
                    ->addAttributeToSelect('stock_status')
                    ->addFilter('type_id', 'simple')*/;
                    /*->addAttributeToSort('name', 'ASC');*/
                    
      
       $read = Mage::getSingleton("core/resource")->getConnection("core_read"); 
      $select = $read->select()->from(array("a" => "eav_attribute"), array("attribute_id", "attribute_code"))
      		->join(array("ao" => "eav_attribute_option"), "a.attribute_id = ao.attribute_id AND a.entity_type_id=4  AND a.is_user_defined=1 AND a.frontend_input='select'", array())
      		->order("frontend_label"); 
       $data= $read->fetchPairs ($select);
	   //print_r($data);
	   //die();
       $attributes=array_keys( $data) ;
      //print_r( $attributes);
      //$countSelect =  $collection->getSelect();
      //$countSelect->reset()->from(array('e'=>'catalog_product_entity'));
      $optionsTable=array('options_table'=>$prefix.'eav_attribute_option');
      $valuesTable=array('values_table'=>$prefix.'eav_attribute_option_value');
      $valueTable=array('value_table'=>$prefix.'catalog_product_entity_int');
      $attrTable=array('at_table'=>$prefix.'eav_attribute');
      //$collection->addFilterToMap('status', 'main_table.status');
      /*$countSelect->joinLEFT($valueTable, 'value_table.entity_id = e.entity_id',array());
      $countSelect->joinLEFT($attrTable, 'at_table.attribute_id = value_table.attribute_id AND at_table.attribute_id IN ('.implode(',', $attributes).')',array("frontend_label"));
      $countSelect->join(array("ao" => "eav_attribute_option"), "at_table.attribute_id = ao.attribute_id", array());
      $countSelect->joinLEFT($optionsTable, 'options_table.attribute_id = at_table.attribute_id AND value_table.value=options_table.option_id',array());
      $countSelect->joinLEFT($valuesTable, 'values_table.option_id = options_table.option_id',array('color'=>'value'));
      $countSelect->where('at_table.attribute_code=?','color');*/
      $storeId='';
       /*$collection = Mage::getResourceModel('reports/product_lowstock_collection')
            ->addAttributeToSelect('*')
            ->setStoreId($storeId)
            ->filterByIsQtyProductTypes()
            ->joinInventoryItem('qty')
            ->useManageStockFilter($storeId)
            ->useNotifyStockQtyFilter($storeId)
            ->setOrder('qty', Varien_Data_Collection::SORT_ORDER_ASC);*/
       
       $collection = Mage::getModel('catalog/product')->getCollection()
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
       foreach($data as $code =>$label):
      	//echo $code.'<br/>';
      	//$collection->addAttributeToSelect($code);
	//$collection->setStoreId($store->getId());
	//$collection->addStoreFilter($store);
		//$collection->joinAttribute($code, 'catalog_product/'.$code, 'entity_id', null, 'left', '0');
       endforeach;
       //$collection->joinAttribute('color', 'catalog_product/color', 'entity_id', null, 'left', '0');
       //$collection->joinAttribute('belt_size', 'catalog_product/belt_size', 'entity_id', null, 'inner', '0');
       //$collection->joinAttribute('special_orders', 'catalog_product/special_orders', 'entity_id', null, 'inner', '0');
       $countSelect =  $collection->getSelect();
	   foreach($data as $id =>$code)
	   {	$tableName='at_'.$code;
			$table=array($tableName=>'catalog_product_entity_int');
			$countSelect->joinLeft($table, $tableName.'.entity_id = e.entity_id AND '.$tableName.'.attribute_id='.$id,array($code=>$tableName.'.value'));
			
			$textTableName='txt_'.$code;
			$textTable=array($textTableName=>'eav_attribute_option_value');
			$countSelect->joinLeft($textTable, $textTableName.'.option_id = '.$tableName.'.value',array($textTableName=>$textTableName.'.value'));
	   }
      //$countSelect->joinLEFT($attrTable, 'at_table.attribute_id = value_table.attribute_id AND at_table.attribute_id IN ('.implode(',', $attributes).')',array("frontend_label"));
       echo  $countSelect;
      $this->setCollection($collection);
      
     
     // var_dump($data);
    
      
      return parent::_prepareCollection();
  }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    =>Mage::helper('inventory')->__('ID'),
            'sortable'  =>false,
            'index'     =>'entity_id'
        ));
        
        $this->addColumn('name', array(
            'header'    =>Mage::helper('inventory')->__('Product Name'),
            'sortable'  =>false,
            'index'     =>'name'
        ));
        

        $this->addColumn('sku', array(
            'header'    =>Mage::helper('inventory')->__('Product Code'),
            'sortable'  =>false,
            'index'     =>'sku'
        ));

	$this->addColumn('attr', array(
            'header'    =>Mage::helper('inventory')->__('Attributes'),
            'sortable'  =>false,
            'index'     =>'attr',
            'renderer'	=>'As_Inventory_Block_Adminhtml_Inventory_Column_Attribute'
            
        ));

        $this->addColumn('qty', array(
            'header'    =>Mage::helper('inventory')->__('Stock Qty'),
            'width'     =>'215px',
            'align'     =>'right',
            'sortable'  =>false,
            'filter'    =>'adminhtml/widget_grid_column_filter_range',
            'index'     =>'qty',
            'type'      =>'number'
        ));

        $this->addExportType('*/*/exportLowstockCsv', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportLowstockExcel', Mage::helper('reports')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('inventory_id');
        $this->getMassactionBlock()->setFormFieldName('inventory');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('inventory')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('inventory')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('inventory/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('inventory')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('inventory')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      //return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
