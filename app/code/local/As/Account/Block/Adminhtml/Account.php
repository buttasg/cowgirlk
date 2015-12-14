<?php
class As_Account_Block_Adminhtml_Account extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_account';
    $this->_blockGroup = 'account';
    $this->_headerText = Mage::helper('account')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('account')->__('Add Item');
    parent::__construct();
  }
}