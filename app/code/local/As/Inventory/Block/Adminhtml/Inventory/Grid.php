<?php

class As_Inventory_Block_Adminhtml_Inventory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  protected $_countTotals = true;
  public function __construct()
  {
      parent::__construct();
      //
      $this->setFilterVisibility(false);
      $this->setId('inventoryGrid');
      $this->setDefaultSort('inventory_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);

  }

  protected function _prepareCollection()
  {   
       $dropship=$this->getRequest()->getParam('dropship');
  
       $helper=Mage::helper('inventory');  
          
       $collection =$helper->getPreparedCollection($dropship);
       $this->setCollection($collection);
      
     
     // var_dump($data);
    
      
      return parent::_prepareCollection();
  }

    public function getTotals()
    {	$dropship=$this->getRequest()->getParam('dropship');
    	$totals = new Varien_Object();
    	 $fields = array(
            'cost' => 0, //actual column index, see _prepareColumns()
            'qty' => 0,
            'total_cost' => 0,
        );
        
        if(!$dropship)
        {
        $totals = new Varien_Object();
       
        $helper=Mage::helper('inventory');      
        $collection =$helper->getPreparedCollection();
        $total=0;
        foreach ($collection as $item) {
           $cost=(float)$item->getData('cost');
            $qty=(float)$item->getData('qty');
            $total+=($qty*$cost);
            
        }
     
        $fields['cost']=null;
        $fields['qty']=null;
        //First column in the grid
        $fields['total_cost']=$total;//number_format($total,2);
        $fields['sku']='Totals :';
        }
         $totals->setData($fields);
        return $totals;
    }


    protected function _prepareColumns()
    {	
        /*$this->addColumn('entity_id', array(
            'header'    =>Mage::helper('inventory')->__('ID'),
            'sortable'  =>false,
            'index'     =>'entity_id'
        ));*/
        
        $this->addColumn('product_code', array(
            'header'    =>Mage::helper('inventory')->__('Product Code'),
            'sortable'  =>false,
            'index'     =>'product_code'
        ));
        
        $this->addColumn('name', array(
            'header'    =>Mage::helper('inventory')->__('Product Name'),
            'sortable'  =>false,
            'index'     =>'name'
        ));
        
	
	 $this->addColumn('txt_brand', array(
            'header'    =>Mage::helper('inventory')->__('Vendor'),
            'sortable'  =>false,
             'width'     =>'215px',
            'index'     =>'txt_brand'
        ));
        

	$this->addColumn('attr', array(
            'header'    =>Mage::helper('inventory')->__('Combination'),
            'sortable'  =>false,
            'index'     =>'attr',
             'width'     =>'215px',
            'renderer'	=>'As_Inventory_Block_Adminhtml_Inventory_Column_Attribute'
            
        ));

        $this->addColumn('qty', array(
            'header'    =>Mage::helper('inventory')->__('Inventory amount'),
            'width'     =>'50px',
            'align'     =>'right',
            'sortable'  =>false,
            'filter'    =>'adminhtml/widget_grid_column_filter_range',
            'index'     =>'qty',
            'type'      =>'number'
        ));
	
	
	$this->addColumn('cost', array(
            'header'    =>Mage::helper('inventory')->__('Product Cost Price'),
            'width'     =>'105px',
            'align'     =>'right',
            'sortable'  =>false,
            /*'index'     =>'cost',*/
            'renderer'  =>'As_Inventory_Block_Adminhtml_Inventory_Column_Cost',
            'type'      =>'number'
        ));
        
        $this->addColumn('total_cost', array(
            'header'    =>Mage::helper('inventory')->__('Total Cost'),
            'width'     =>'105px',
            'align'     =>'right',
            'sortable'  =>false,
            'index'     =>'total_cost',
            'renderer'  =>'As_Inventory_Block_Adminhtml_Inventory_Column_Cost_Total',
            'type'      =>'number'
        ));
        
        $this->addExportType('*/*/exportCsv/limit/5000', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportXml/', Mage::helper('reports')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        //$this->setMassactionIdField('inventory_id');
        //$this->getMassactionBlock()->setFormFieldName('inventory');

        //$this->getMassactionBlock()->addItem('delete', array(
         //    'label'    => Mage::helper('inventory')->__('Delete'),
           //  'url'      => $this->getUrl('*/*/massDelete'),
            // 'confirm'  => Mage::helper('inventory')->__('Are you sure?')
        //));

        //$statuses = Mage::getSingleton('inventory/status')->getOptionArray();

       //array_unshift($statuses, array('label'=>'', 'value'=>''));
        //$this->getMassactionBlock()->addItem('status', array(
          //   'label'=> Mage::helper('inventory')->__('Change status'),
            // 'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             //'additional' => array(
               //     'visibility' => array(
                 //        'name' => 'status',
                   //      'type' => 'select',
                     //    'class' => 'required-entry',
                       // 'label' => Mage::helper('inventory')->__('Status'),
                       //  'values' => $statuses
                     //)
        	//)
        //));
       
       
        return $this;
    }

  public function getRowUrl($row)
  {
      //return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
