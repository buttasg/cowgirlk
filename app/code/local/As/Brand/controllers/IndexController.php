<?php
class As_Brand_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout(); 
		
		$this->getLayout()->getBlock('breadcrumbs')->addCrumb('home', 
                           array('label' => Mage::helper('brand')->__('Home'),
                             'title' => Mage::helper('brand')->__('Go to Home Page'),
                             'link' => Mage::getBaseUrl()) )
                              ->addCrumb('brand', array('label' => Mage::helper('brand')->__('Brands')) );
		$this->getLayout()->getBlock('head')->setTitle('Brands'); 
		$this->renderLayout();

    }
	
	public function viewProductsAction()
	{	$identifier=$this->getRequest()->getParam('identifier');
		$brand=null;
		if(!empty($identifier)) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$brandTable = $resource->getTableName('brand');
			
			$select = $read->select()
			   ->from($brandTable,array('brand_id','title','content','status'))
			   ->where('url=?',$identifier)
			   ->order('created_time DESC') ;
			   
			$brand = $read->fetchRow($select);
			Mage::register('current_brand', $brand['brand_id']);
		}

		$this->loadLayout();
		if($brand){
		$this->getLayout()->getBlock('head')->setTitle('Brands / '.$brand['title']); 
		$this->getLayout()->getBlock('breadcrumbs')
		->addCrumb('home', array('label' => Mage::helper('brand')->__('Home'), 
				   'title' => Mage::helper('brand')->__('Go to Home Page'), 'link' => Mage::getBaseUrl())) 
		->addCrumb('brand', array('label' => Mage::helper('brand')->__('Brands'), 
				   'link' => Mage::getBaseUrl().Mage::helper('brand')->getBrandsUrl()))
		->addCrumb('brand_product', array('label' => Mage::helper('brand')->__($brand['title']))) ;
		}
		$this->renderLayout();
	}
}