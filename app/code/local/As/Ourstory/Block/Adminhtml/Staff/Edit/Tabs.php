<?php

class As_Ourstory_Block_Adminhtml_Staff_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('staff_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ourstory')->__('Staff Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ourstory')->__('Staff Information'),
          'title'     => Mage::helper('ourstory')->__('Staff Information'),
          'content'   => $this->getLayout()->createBlock('ourstory/adminhtml_staff_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}