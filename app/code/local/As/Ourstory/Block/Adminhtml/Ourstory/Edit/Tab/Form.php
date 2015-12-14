<?php

class As_Ourstory_Block_Adminhtml_Ourstory_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('ourstory_form', array('legend'=>Mage::helper('ourstory')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('ourstory')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      /*$fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('ourstory')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));*/
		
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
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('ourstory')->__('Content'),
          'title'     => Mage::helper('ourstory')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
     if($this->getRequest()->getParam("id")=="1")
     {
      /*$fieldset->addField('meta_title', 'textarea', array(
          'name'      => 'meta_title',
          'label'     => Mage::helper('ourstory')->__('Meta Title'),
          'title'     => Mage::helper('ourstory')->__('Meta Title')
      ));*/
     
      $fieldset->addField('meta_keywords', 'textarea', array(
          'name'      => 'meta_keywords',
          'label'     => Mage::helper('ourstory')->__('Meta Keywords'),
          'title'     => Mage::helper('ourstory')->__('Meta Keywords')
      ));
      
      $fieldset->addField('meta_description', 'textarea', array(
          'name'      => 'meta_description',
          'label'     => Mage::helper('ourstory')->__('Meta Description'),
          'title'     => Mage::helper('ourstory')->__('Meta Description')
      ));
     }
      if ( Mage::getSingleton('adminhtml/session')->getOurstoryData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getOurstoryData());
          Mage::getSingleton('adminhtml/session')->setOurstoryData(null);
      } elseif ( Mage::registry('ourstory_data') ) {
          $form->setValues(Mage::registry('ourstory_data')->getData());
      }
      return parent::_prepareForm();
  }
}
