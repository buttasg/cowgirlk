<?php

class As_Homeslider_Block_Adminhtml_Homeslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('homeslider_form', array('legend'=>Mage::helper('homeslider')->__('Slide information')));
     
      $fieldset->addField('first_title', 'text', array(
          'label'     => Mage::helper('homeslider')->__('Product Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'first_title',
      ));
	  
	 $fieldset->addField('second_title', 'text', array(
          'label'     => Mage::helper('homeslider')->__('Brand Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'second_title',
      ));
	  
      $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('homeslider')->__('Link'),
		  'class'	=>'validate-url',
          'required'  => false,
          'name'      => 'link',
	  ));
		
	 $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('homeslider')->__('File'),
          'required'  => true,
          'name'      => 'filename',
           'note'     =>'upload file with width:745px and height:570'
	  ));
	
	$fieldset->addField('position', 'text', array(
          'label'     => Mage::helper('homeslider')->__('Position'),
	  'class'	=>'validate-number required-entry',
          'required'  => true,
          'name'      => 'position',
	  ));  
	 
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('homeslider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('homeslider')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('homeslider')->__('Disabled'),
              ),
          ),
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getHomesliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getHomesliderData());
          Mage::getSingleton('adminhtml/session')->setHomesliderData(null);
      } elseif ( Mage::registry('homeslider_data') ) {
          $form->setValues(Mage::registry('homeslider_data')->getData());
      }
      return parent::_prepareForm();
  }
}
