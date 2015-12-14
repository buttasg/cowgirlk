<?php

class As_Homeslider_Block_Adminhtml_Homeslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('homesliderGrid');
      $this->setDefaultSort('homeslider_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('homeslider/homeslider')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('homeslider_id', array(
          'header'    => Mage::helper('homeslider')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'homeslider_id',
      ));

      $this->addColumn('first_title', array(
          'header'    => Mage::helper('homeslider')->__('Product Name'),
          'align'     =>'left',
          'index'     => 'first_title',
      ));
	
	  $this->addColumn('second_title', array(
          'header'    => Mage::helper('homeslider')->__('Brand Name'),
          'align'     =>'left',
          'index'     => 'second_title',
      ));
      
       $this->addColumn('position', array(
          'header'    => Mage::helper('homeslider')->__('Position'),
          'align'     =>'right',
          'index'     => 'position',
      ));
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('homeslider')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('homeslider')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('homeslider')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('homeslider')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('homeslider')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('homeslider')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('homeslider_id');
        $this->getMassactionBlock()->setFormFieldName('homeslider');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('homeslider')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('homeslider')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('homeslider/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('homeslider')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('homeslider')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
