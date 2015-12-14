<?php

class As_Ourstory_Block_Adminhtml_Staff_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('staff_form', array('legend'=>Mage::helper('ourstory')->__('Staff information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('ourstory')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));

      $fieldset->addField('designation', 'text', array(
          'label'     => Mage::helper('ourstory')->__('Designation'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'designation',
      ));
      
      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('ourstory')->__('File'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('ourstory')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('ourstory')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('ourstory')->__('Disabled'),
              ),
          ),
      ));
         
      if ( Mage::getSingleton('adminhtml/session')->getOurstoryData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOurstoryData());
          Mage::getSingleton('adminhtml/session')->setOurstoryData(null);
      } elseif ( Mage::registry('staff_data') ) {
          $form->setValues(Mage::registry('staff_data')->getData());
      }
      return parent::_prepareForm();
  }
}