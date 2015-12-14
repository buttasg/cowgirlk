<?php

class As_Inventory_Block_Adminhtml_Inventory_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('inventory_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('inventory')->__('Net Sales & Tax Report'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('inventory')->__('Net Sales & Tax Report'),
          'title'     => Mage::helper('inventory')->__('Report Information'),
          'content'   => $this->getLayout()->createBlock('inventory/adminhtml_inventory_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
