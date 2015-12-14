<?php
class As_Homeslider_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/homeslider?id=15 
    	 *  or
    	 * http://site.com/homeslider/id/15 	
    	 */
    	/* 
		$homeslider_id = $this->getRequest()->getParam('id');

  		if($homeslider_id != null && $homeslider_id != '')	{
			$homeslider = Mage::getModel('homeslider/homeslider')->load($homeslider_id)->getData();
		} else {
			$homeslider = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($homeslider == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$homesliderTable = $resource->getTableName('homeslider');
			
			$select = $read->select()
			   ->from($homesliderTable,array('homeslider_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$homeslider = $read->fetchRow($select);
		}
		Mage::register('homeslider', $homeslider);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}