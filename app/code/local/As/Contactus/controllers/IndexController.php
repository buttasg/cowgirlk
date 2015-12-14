<?php
require_once ('Mage/Contacts/controllers/IndexController.php');
class As_Contactus_IndexController extends Mage_Contacts_IndexController
{
    public function postAction()
    {	
        $post = $this->getRequest()->getPost();
        if ( $post ) {
            $translate = Mage::getSingleton('core/translate');
            /* @var $translate Mage_Core_Model_Translate */
            $translate->setTranslateInline(false);
            try {
            	$arr=Mage::helper('contactus')->getOptions();
            	$post['question']=isset($arr[$post['question']])?$arr[$post['question']]:null;
                $postObject = new Varien_Object();
                $postObject->setData($post);

                $error = false;

                if (!Zend_Validate::is(trim($post['name']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['comment']) , 'NotEmpty')) {
                    $error = true;
                }

                if (!Zend_Validate::is(trim($post['email']), 'EmailAddress')) {
                    $error = true;
                }
		/*if (!Zend_Validate::is(trim($post['order']), 'NotEmpty')) {
                    $error = true;
                }*/
                
   		if (!Zend_Validate::is(trim($post['comment']), 'NotEmpty')) {
                    $error = true;
                }             
                
                
                if (Zend_Validate::is(trim($post['hideit']), 'NotEmpty')) {
                    $error = true;
                }

                if ($error) {
                    throw new Exception('Please fill all required fields.');
                }
                
                $mailTemplate = Mage::getModel('core/email_template');
                /* @var $mailTemplate Mage_Core_Model_Email_Template */
                $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                    ->setReplyTo($post['email'])
                    ->sendTransactional(
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                        Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                        null,
                        array('data' => $postObject)
                    );
		
		$emailTemplate = Mage::getModel('core/email_template')->loadDefault('contactus_auto_responder');
		
		$sender=Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT);
		$emailTemplate->setSenderName('Cowgirl Kim');
            	$emailTemplate->setSenderEmail($sender);
           	$emailTemplate->setType('html');
            	$emailTemplate->setTemplateSubject('Help Is On Its Way');
            	//$emailTemplate->send($post['email'], $post['name'], array('data' => $postObject));
		
		
                /*if (!$mailTemplate->getSentSuccess()) {
                    throw new Exception();
                }*/

                $translate->setTranslateInline(true);

                //Mage::getSingleton('customer/session')->addSuccess(Mage::helper('contacts')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.'));
                Mage::getSingleton('customer/session')->setPostedEmail($post['email']);
                $url=Mage::getUrl('contacts/index/confirmation',array('_secure'=>true));
                //echo $url; die();
                $this->_redirectUrl($url);
                return;
            } catch (Exception $e) {
                $translate->setTranslateInline(true);

                Mage::getSingleton('customer/session')->addError(Mage::helper('contacts')->__('Unable to submit your request. Please, try again later.'));
                $this->_redirect('*/*/');
                return;
            }

        } else {
            $this->_redirect('*/*/');
        }
    }
    
    public function confirmationAction()
    {	//$email=Mage::getSingleton('customer/session')->getPostedEmail();
    	//if($email){
    		
    		$this->loadLayout();
    		$this->renderLayout();
    	//	Mage::getSingleton('customer/session')->setPostedEmail(null);
    	//}
    	//else 
    	//{
          //  $this->_redirect('*/*/');
        //}
    }
}
