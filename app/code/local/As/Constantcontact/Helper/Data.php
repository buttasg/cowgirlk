<?php

class As_Constantcontact_Helper_Data extends Mage_Core_Helper_Abstract
{
    public $apiPath='https://api.constantcontact.com/v2';
    
    public function getJsons($params)
    {
        $json=  json_encode($params);
        return $json;
    }
    
    
    public function decodeJson($json)
    {
        return json_decode($json);
    }


    public function subscribe($email)
    {   $listId=Mage::getStoreConfig('constantcontact/constantcontact/listid');
        $apiKey=Mage::getStoreConfig('constantcontact/constantcontact/api_key');
        //$url='https://api.constantcontact.com/v2/lists?api_key='.$apiKey;//for contact lists
        $url=$this->apiPath.'/contacts?action_by=ACTION_BY_VISITOR&api_key='.$apiKey;
        $data=array();
        $data['lists'][]['id']=$listId;
        $data['confirmed']=null;
        $data['email_addresses'][]['email_address']=$email;
        $data['fax']='';
        $data['first_name']='';
        $data['home_phone']='';
        $data['job_title']='';
        $data['last_name']='';
        $data['middle_name']='';
        $data['prefix_name']='';
        $data['work_phone']='';
        $obj=Mage::getModel('constantcontact/constantcontact');
        $json=$this->getJsons($data);
        return $obj->doServerCall($url,$json,'POST');
    }
    
    public function subscriberExists($email = '') {
        $apiKey=Mage::getStoreConfig('constantcontact/constantcontact/api_key');
        $url = $this->apiPath.'/contacts?email='.urlencode($email).'&api_key='.$apiKey;
        $obj=Mage::getModel('constantcontact/constantcontact');

        $json = $obj->doServerCall($url,null);
        
        $data=(array)$this->decodeJson($json);

        if(isset($data['results']) && !empty($data['results']))
        { 
            return true; 

        }
        else
        { 
            return false; 
            
        }
    }
    
    public function isValidEmail($value)
    {
        return Zend_Validate::is($value, 'EmailAddress');
    }
}
