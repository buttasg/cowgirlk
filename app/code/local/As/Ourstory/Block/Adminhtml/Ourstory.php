<?php
class As_Ourstory_Block_Adminhtml_Ourstory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_ourstory';
    $this->_blockGroup = 'ourstory';
    $this->_headerText = Mage::helper('ourstory')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('ourstory')->__('Add Item');
    parent::__construct();
  }
}