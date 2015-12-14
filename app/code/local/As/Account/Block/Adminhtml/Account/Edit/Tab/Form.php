<?php

class As_Account_Block_Adminhtml_Account_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('account_form', array('legend'=>Mage::helper('account')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('account')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('account')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('account')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('account')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('account')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('account')->__('Content'),
          'title'     => Mage::helper('account')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getAccountData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getAccountData());
          Mage::getSingleton('adminhtml/session')->setAccountData(null);
      } elseif ( Mage::registry('account_data') ) {
          $form->setValues(Mage::registry('account_data')->getData());
      }
      return parent::_prepareForm();
  }
}