<?php

class As_Inventory_Block_Adminhtml_Inventory_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'inventory';
        $this->_controller = 'adminhtml_inventory';
        
        
        $this->_updateButton('save', 'label', Mage::helper('inventory')->__('Export Report'));
        
		
        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('inventory_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'inventory_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'inventory_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
    
        return Mage::helper('inventory')->__('Net Sales & Tax Report');
    }
}
