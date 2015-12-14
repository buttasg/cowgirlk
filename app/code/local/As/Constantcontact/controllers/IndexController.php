<?php
class As_Constantcontact_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    				
	$this->loadLayout();     
	$this->renderLayout();
    }
    
    public function subscribeVisitorAction()
    {
        $helper=Mage::helper('constantcontact');
        $request=$this->getRequest();

        if($request->isPost())
        {	
            $email=$request->getParam('email');
            $response=array();
            $response['email']=$email;
            
            if(!$helper->isValidEmail($email))
            {	
                $response['error']="true";
                $response['message']="Enter valid email address.";
                $this->_sendResponse($response);
                return;
            }
            
            
            $result=$helper->subscriberExists($email);
            if($result)
            {	
                $response['error']="true";
                $response['message']="You are already subscribed with ".$email.".";
                $this->_sendResponse($response);
                return;
            }
            
            $subscribed=$helper->subscribe($email);

            if($subscribed)
            {	
            	$result=(array)$helper->decodeJson($subscribed);
            	if(isset($result["error_key"]))
            	{	
            		 $response['error']="true";
               		 $response['message']=$result["error_message"];
                	 $this->_sendResponse($response);
               		 return;
            	}
		
                $response['success']="true";
                $response['message']="You have successfully subscribed.";
                $this->_sendResponse($response);
                return;
                
            }
            
        }
        else 
        {
            $this->getResponse()->setHeader('HTTP/1.1','403 Forbidden');
        }
        
    }
    
    public function confirmationAction()
    {  $status=Mage::getSingleton('core/session')->getSubscribeStatus();
       $this->loadLayout();     
       $this->renderLayout();
    }
    
    private function _sendResponse($response)
    {
    	$this->getResponse()->setHeader('Content-type', 'application/x-json');
            
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}
