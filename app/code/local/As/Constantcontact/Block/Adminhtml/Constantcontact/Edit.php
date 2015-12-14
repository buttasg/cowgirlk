<?php

class As_Constantcontact_Block_Adminhtml_Constantcontact_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'constantcontact';
        $this->_controller = 'adminhtml_constantcontact';
        
        $this->_updateButton('save', 'label', Mage::helper('constantcontact')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('constantcontact')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('constantcontact_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'constantcontact_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'constantcontact_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('constantcontact_data') && Mage::registry('constantcontact_data')->getId() ) {
            return Mage::helper('constantcontact')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('constantcontact_data')->getTitle()));
        } else {
            return Mage::helper('constantcontact')->__('Add Item');
        }
    }
}