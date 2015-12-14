<?php

class As_Homeslider_Block_Adminhtml_Homeslider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'homeslider';
        $this->_controller = 'adminhtml_homeslider';
        
        $this->_updateButton('save', 'label', Mage::helper('homeslider')->__('Save Slide'));
        $this->_updateButton('delete', 'label', Mage::helper('homeslider')->__('Delete Slide'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('homeslider_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'homeslider_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'homeslider_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('homeslider_data') && Mage::registry('homeslider_data')->getId() ) {
            $title=Mage::registry('homeslider_data')->getFirstTitle().' '.Mage::registry('homeslider_data')->getSecondTitle();
            return Mage::helper('homeslider')->__("Edit '%s'", $this->htmlEscape( $title));
        } else {
            return Mage::helper('homeslider')->__('Add Slide');
        }
    }
}
