<?php
class As_Constantcontact_Block_Adminhtml_Constantcontact extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_constantcontact';
    $this->_blockGroup = 'constantcontact';
    $this->_headerText = Mage::helper('constantcontact')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('constantcontact')->__('Add Item');
    parent::__construct();
  }
}