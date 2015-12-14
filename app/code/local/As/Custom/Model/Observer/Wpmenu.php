<?php
class As_Custom_Model_Observer_Wpmenu extends Mage_Core_Model_Abstract
{	

	public function wpMenuCache()
	{	try
		{	
		   $filename=dirname(Mage::getRoot()).DS.'media'.DS.'wp'.DS.'topmenu';
			if(file_exists($filename))
			{
			   @unlink($filename);
			}
			$url="http://".$_SERVER['HTTP_HOST']."/mg2wp/index.php/?block=topmenu";
			
			$html=@file_get_contents($url);
			//Mage::log($html,null,'wp_menu.log');
		}
		catch(Exception $e)
		{
			Mage::log($e->getMessage(),null,'wp_menu_error.log');
		}
	}
	
}
 
