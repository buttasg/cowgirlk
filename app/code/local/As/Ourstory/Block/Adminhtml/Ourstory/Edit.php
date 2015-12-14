<?php

class As_Ourstory_Block_Adminhtml_Ourstory_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'ourstory';
        $this->_controller = 'adminhtml_ourstory';
        
        //$this->_updateButton('save', 'label', Mage::helper('ourstory')->__('Save Item'));
        //$this->_updateButton('delete', 'label', Mage::helper('ourstory')->__('Delete Item'));
		
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
            }*/

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
        $this->_removeButton('add');
        $this->_removeButton('delete');
        $this->_removeButton('save');
        $this->_removeButton('back');
    }

    public function getHeaderText()
    {
        if( Mage::registry('ourstory_data') && Mage::registry('ourstory_data')->getId() ) {
            return Mage::helper('ourstory')->__("Edit '%s'", $this->htmlEscape(Mage::registry('ourstory_data')->getTitle()));
        } else {
            return Mage::helper('ourstory')->__('Add Story');
        }
    }
}