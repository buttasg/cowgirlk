<?php

class As_Contactus_Block_Adminhtml_Contactus_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'contactus';
        $this->_controller = 'adminhtml_contactus';
        
        $this->_updateButton('save', 'label', Mage::helper('contactus')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('contactus')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('contactus_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'contactus_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'contactus_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('contactus_data') && Mage::registry('contactus_data')->getId() ) {
            return Mage::helper('contactus')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('contactus_data')->getTitle()));
        } else {
            return Mage::helper('contactus')->__('Add Item');
        }
    }
}