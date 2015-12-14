<?php

class As_Account_Block_Adminhtml_Account_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'account';
        $this->_controller = 'adminhtml_account';
        
        $this->_updateButton('save', 'label', Mage::helper('account')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('account')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('account_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'account_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'account_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('account_data') && Mage::registry('account_data')->getId() ) {
            return Mage::helper('account')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('account_data')->getTitle()));
        } else {
            return Mage::helper('account')->__('Add Item');
        }
    }
}