<?php
class As_Custom_Model_Observer_Wpcart extends Mage_Core_Model_Abstract
{	

	public function remove()
	{	try
		{	
		    $dir=BP."/var/wp/*";
			$list=glob($dir);
			foreach($list as $file) 
			{
			  if(is_file($file))
			  {
				 $filetime=filemtime($file);
				 
				 $time=time()-3600;
				 
				 if($filetime<$time)
				 { 
					@unlink($file);
				 }
			  }
			}
			//Mage::log($html,null,'wp_menu.log');
		}
		catch(Exception $e)
		{
			Mage::log($e->getMessage(),null,'wp_cart_error.log');
		}
	}
	
}
 
