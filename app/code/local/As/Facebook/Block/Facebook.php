<?php
class As_Facebook_Block_Facebook extends Mage_Core_Block_Template
{
	public function _prepareLayout()
	{
	  return parent::_prepareLayout();
    	}
    
     public function getfeed()     
     { 
       $clientId=Mage::getStoreConfig("facebook/feed/user_id");
       
       $secret=Mage::getStoreConfig("facebook/feed/app_secret");
       
       $pageId=Mage::getStoreConfig("facebook/feed/page_id");
       
       
       if(!empty($clientId) && !empty($secret) && !empty($pageId))
       {
       		$response = @file_get_contents('https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$clientId.'&client_secret='.$secret);
       		$token = str_replace('access_token=', '', $response);
       		$url="https://graph.facebook.com/".$pageId."?fields=feed&access_token=". $token.'&limit=1';
       		$json = @file_get_contents($url);
		$feed = json_decode($json,true);
		return $feed;
       }
        
       return false;
     }
}
