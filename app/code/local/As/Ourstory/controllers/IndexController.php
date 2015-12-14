<?php
class As_Ourstory_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/ourstory?id=15 
    	 *  or
    	 * http://site.com/ourstory/id/15 	
    	 */
    	/* 
		$ourstory_id = $this->getRequest()->getParam('id');

  		if($ourstory_id != null && $ourstory_id != '')	{
			$ourstory = Mage::getModel('ourstory/ourstory')->load($ourstory_id)->getData();
		} else {
			$ourstory = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($ourstory == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$ourstoryTable = $resource->getTableName('ourstory');
			
			$select = $read->select()
			   ->from($ourstoryTable,array('ourstory_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$ourstory = $read->fetchRow($select);
		}
		Mage::register('ourstory', $ourstory);
		*/
	
	
			
		$this->loadLayout(); 
		
		$story=Mage::getModel('ourstory/ourstory')->load(1);
		
		$head = $this->getLayout()->getBlock('head');

		if(!empty($story['title'])){
		$head->setTitle($story['title']);
		}
		
		if(!empty($story['meta_keywords'])){
		$head->setKeywords($story['meta_keywords']);
		}
		
		if(!empty($story['meta_description'])){
			$head->setDescription($story['meta_description']);
		}
		    
		$this->renderLayout();
    }
}
