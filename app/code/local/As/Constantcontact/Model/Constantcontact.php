<?php

class As_Constantcontact_Model_Constantcontact extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('constantcontact/constantcontact');
    }
    
    public  function doServerCall($url,$params,$type='GET')
    {	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_USERPWD, $this->requestLogin);
         # curl_setopt ($ch, CURLOPT_FOLLOWLOCATION ,1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers=array();
        $headers[]="Content-Type:application/application/json";
        $headers[]="Authorization:Bearer ".Mage::getStoreConfig('constantcontact/constantcontact/token');


        if(!empty($params)){
            $headers[]="Content-Length:".strlen($params);
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            switch ($type) {
                case 'POST':
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    break;
                case 'PUT':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    break;
                case 'DELETE':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    break;
                default:
                case 'GET':
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    break;
            }
	   Mage::log($params, null, 'constant_contacts_request.log');
           $emessage = curl_exec($ch);
           Mage::log($emessage, null, 'constant_contacts_result.log');
           
           if ($errorno=curl_errno($ch)) 
            {  
               $error=curl_error($ch);
               Mage::log($error, null, 'constant_contacts_error.log');
               return false; 
               
           }
           curl_close($ch);  
 	   //echo 'Result=='.print_r($emessage,true);
           return $emessage;
    }
}
