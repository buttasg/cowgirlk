<?php
class As_Ourstory_Block_Adminhtml_Staff extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {  
    $this->_controller = 'adminhtml_staff';
    $this->_blockGroup = 'ourstory';
    $this->_headerText = Mage::helper('ourstory')->__('Staff Manager');
    $this->_addButtonLabel = Mage::helper('ourstory')->__('Add staff');
    parent::__construct();
  }
}