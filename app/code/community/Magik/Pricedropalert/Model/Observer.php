<?php
class Magik_Pricedropalert_Model_Observer
{

	public function sendAlert()
	{

		$emailTemplateId=Mage::getStoreConfig('pricedrop_section/pricedrop_general/pricedrop_template',Mage::app()->getStore());
		$senderEmail=Mage::getStoreConfig('pricedrop_section/pricedrop_general/pricedrop_emailreply',Mage::app()->getStore());
		
	        $senderEmailName=Mage::getStoreConfig('pricedrop_section/pricedrop_general/pricedrop_emailreplyname',Mage::app()->getStore());
		$data = Mage::getModel('pricedropalert/pricedropalert')->getList1();
		

		$prodIds = Mage::getModel('pricedropalert/pricedropalert')->getProductId();
		foreach($prodIds as $productId) 
		{			
		    foreach($data as  $key=>$val)
		    {			
			    if($val['productid']==$productId)
			    {	
								//Mage::log('beforePricedrop email:' . $val['email']. ' Product name:'.$val['product_name']);
			    	//Mage::log("beforepricedrop notissset:". !isset($val['update_time']) . " update_time:". $val['update_time']. "  update_condition: " . (strtotime($val['update_time']) < strtotime('1 day ago') ) );
			    	if(!isset($val['update_time']) || (strtotime($val['update_time']) < strtotime('1 day ago') ) )	
				    {	
						  $my_product = Mage::getModel('catalog/product')->load($val['productid']); 
						  $produrl=$my_product->getProductUrl(); 
					      //$org = number_format(Mage::getModel('pricedropalert/pricedropalert')->getPrice($productId),2);
						  $org = Mage::getModel('pricedropalert/pricedropalert')->getPrice($productId);
						  $sym = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol(); 	    
			    	//Mage::log("beforepricedrop notissset:". $org . " update_time:". $val['product_price']. "  update_condition: " . ($val['product_price'] > $org));
						  if( $val['product_price'] > $org )
						  {	
						  		/********uncomment here for email**********/

								$templateId = $emailTemplateId;        							
								$mailSubject = 'Price Drop for - '.$val['product_name'];
								$sender = Array('name' => $senderEmailName,'email' => $senderEmail);
								$email = $val['email'];
								$storeId = Mage::app()->getStore()->getId();
								/* set default store id instead of 0 */
								if($storeId==0){
								  $storeId = Mage::app()->getWebsite(true)->getDefaultGroup()->getDefaultStoreId();
								}
								$vars = Array('product_name' => $val['product_name'],'product_url' => $produrl,'follow_price' => Mage::helper('core')->currency($val['product_price'],true,false), 'current_price'=>Mage::helper('core')->currency($org,true,false), 'unsubscribe_link'=>Mage::getUrl('pricedropalert/index/unsubscribe/id/'.$val['id']));							
								$etranslate = Mage::getSingleton('core/translate');
									      Mage::getModel('core/email_template')
										  ->setTemplateSubject($mailSubject)
										  ->sendTransactional($templateId, $sender, $email, null, $vars, $storeId);
								$etranslate->setTranslateInline(true);		

								/*********** end of email functionality ********/

								Mage::log('Pricedrop email:' . $val['email']. ' Product name:'.$val['product_name']);
								Mage::log('Previous Price:' . $val['product_price']. ' Current Price:'.$org);
								Mage::getModel('pricedropalert/pricedropalert')->updateDB($val['id'],$org);
							
						  }
					}	  
			    }
		    }
		}
	}

	
}