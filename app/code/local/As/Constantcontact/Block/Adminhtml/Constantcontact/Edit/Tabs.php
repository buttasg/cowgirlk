<?php

class As_Constantcontact_Block_Adminhtml_Constantcontact_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('constantcontact_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('constantcontact')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('constantcontact')->__('Item Information'),
          'title'     => Mage::helper('constantcontact')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('constantcontact/adminhtml_constantcontact_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}