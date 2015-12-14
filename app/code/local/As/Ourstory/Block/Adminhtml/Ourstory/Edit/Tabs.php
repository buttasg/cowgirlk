<?php

class As_Ourstory_Block_Adminhtml_Ourstory_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('ourstory_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ourstory')->__('Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ourstory')->__('Information'),
          'title'     => Mage::helper('ourstory')->__('Information'),
          'content'   => $this->getLayout()->createBlock('ourstory/adminhtml_ourstory_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}