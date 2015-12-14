<?php
class As_Custom_Model_Observer_Wpmenu extends Mage_Core_Model_Abstract
{
	public function saveMenuCache()
	{	try
		{	//$defaultStoreId = Mage::app()->getWebsite()->getDefaultGroup()->getDefaultStoreId();
			//Mage::app()->setCurrentStore($defaultStoreId);
			//Mage::getSingleton('core/session', array('name'=>'frontend'));
			//$_layout  = Mage::getSingleton('core/layout');
			
			//$_block  =	$_layout->createBlock('page/html_topmenu')/*->setTemplate('page/html/topmenu.phtml')*/;
			//$html=$_block->getHtml();
			Mage::app()->loadArea('frontend');

			$layout = Mage::getSingleton('core/layout');

			//load default xml layout handle and generate blocks
			$layout->getUpdate()->load('default');
			$layout->generateXml()->generateBlocks();

			//get the loaded head and header blocks and output
			$headerBlock = $layout->getBlock('header');
			$html=$headerBlock->toHtml();
			$filename=dirname(Mage::getRoot()).DS.'media'.DS.'wp'.DS.'topmenu';
			file_put_contents($filename,$html);
			//Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
			//Mage::getSingleton('core/session', array('name'=>'admintml'));
		}
		catch(Exception $e)
		{
			Mage:log($e->getMessage(),null,'wp_menu_error.log');
		}
	}
}
 