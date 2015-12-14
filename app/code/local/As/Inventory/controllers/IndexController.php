<?php
class As_Inventory_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/inventory?id=15 
    	 *  or
    	 * http://site.com/inventory/id/15 	
    	 */
    	/* 
		$inventory_id = $this->getRequest()->getParam('id');

  		if($inventory_id != null && $inventory_id != '')	{
			$inventory = Mage::getModel('inventory/inventory')->load($inventory_id)->getData();
		} else {
			$inventory = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($inventory == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$inventoryTable = $resource->getTableName('inventory');
			
			$select = $read->select()
			   ->from($inventoryTable,array('inventory_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$inventory = $read->fetchRow($select);
		}
		Mage::register('inventory', $inventory);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}