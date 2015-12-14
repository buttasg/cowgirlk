<?php

class As_Ourstory_Block_Adminhtml_Staff_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'ourstory';
        $this->_controller = 'adminhtml_staff';
        
        $this->_updateButton('save', 'label', Mage::helper('ourstory')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('ourstory')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            /*function toggleEditor() {
                if (tinyMCE.getInstanceById('ourstory_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'ourstory_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'ourstory_content');
                }
            }
            */
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('staff_data') && Mage::registry('staff_data')->getId() ) {
            return Mage::helper('ourstory')->__("Edit Staff '%s'", $this->htmlEscape(Mage::registry('staff_data')->getTitle()));
        } else {
            return Mage::helper('ourstory')->__('Add Staff');
        }
    }
}