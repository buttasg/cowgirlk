<?php
class As_Custom_Model_Observer_Theme extends Mage_Core_Model_Abstract
{	

	public function handleTheme()
	{	try
		{  /*if($_SERVER['REMOTE_ADDR']=='122.180.104.43')
		   {
		    Mage::getDesign()->setArea('frontend')
   			             ->setPackageName('aw_mobile')
    			  	     ->setTheme('iphone');
    		   }*/
		}
		catch(Exception $e)
		{
			Mage::log($e->getMessage(),null,'theme_error.log');
		}
	}
	
}
 
