<?php
class As_Homeslider_Block_Adminhtml_Homeslider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_homeslider';
    $this->_blockGroup = 'homeslider';
    $this->_headerText = Mage::helper('homeslider')->__('Slide Manager');
    $this->_addButtonLabel = Mage::helper('homeslider')->__('Add Slide');
    parent::__construct();
  }
}