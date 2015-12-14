<?php

class As_Inventory_Block_Adminhtml_Inventory_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('inventory_form', array('legend'=>Mage::helper('inventory')->__('Report information')));
     
      $fieldset->addField('from', 'date', array(
          'label'     => Mage::helper('inventory')->__('From'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'from',
          'image'     => $this->getSkinUrl('images/grid-cal.gif'),
          'format'             =>Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_LONG) ,
      ));

      $fieldset->addField('to', 'date', array(
          'label'     => Mage::helper('inventory')->__('To'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'to',
          'image'     => $this->getSkinUrl('images/grid-cal.gif'),
          'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_LONG) ,
          /*'value'              => date( Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
                                  strtotime('next weekday') )*/
      ));
		
 
      
       //$form->setValues(Mage::registry('inventory_data')->getData());
      
      return parent::_prepareForm();
  }
}
