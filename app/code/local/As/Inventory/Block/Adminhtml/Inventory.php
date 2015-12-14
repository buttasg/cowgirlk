<?php
class As_Inventory_Block_Adminhtml_Inventory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  { $dropship=$this->getRequest()->getParam('dropship');
    $text=($dropship=="1")?"Inventory Report (Drop Ship)":"Inventory Report";
    $this->_controller = 'adminhtml_inventory';
    $this->_blockGroup = 'inventory';
    $this->_headerText = Mage::helper('inventory')->__($text);
    $this->_addButtonLabel = Mage::helper('inventory')->__('Add Item');
    parent::__construct();
    $this->_removeButton('add');
    
    $this->_removeButton('back');
  }
}
