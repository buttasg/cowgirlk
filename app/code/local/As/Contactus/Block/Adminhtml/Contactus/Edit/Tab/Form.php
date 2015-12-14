<?php

class As_Contactus_Block_Adminhtml_Contactus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('contactus_form', array('legend'=>Mage::helper('contactus')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('contactus')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('contactus')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('contactus')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('contactus')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('contactus')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('contactus')->__('Content'),
          'title'     => Mage::helper('contactus')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getContactusData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getContactusData());
          Mage::getSingleton('adminhtml/session')->setContactusData(null);
      } elseif ( Mage::registry('contactus_data') ) {
          $form->setValues(Mage::registry('contactus_data')->getData());
      }
      return parent::_prepareForm();
  }
}