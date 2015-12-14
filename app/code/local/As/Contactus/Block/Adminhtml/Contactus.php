<?php
class As_Contactus_Block_Adminhtml_Contactus extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_contactus';
    $this->_blockGroup = 'contactus';
    $this->_headerText = Mage::helper('contactus')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('contactus')->__('Add Item');
    parent::__construct();
  }
}