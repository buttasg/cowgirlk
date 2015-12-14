<?php

class As_Inventory_Adminhtml_SaleController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('inventory/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	} 
	
	public function indexAction() {
			$this->loadLayout();
			$this->_setActiveMenu('inventory/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('inventory/adminhtml_inventory_edit'))
				->_addLeft($this->getLayout()->createBlock('inventory/adminhtml_inventory_edit_tabs'));

			$this->renderLayout();
	if ($data = $this->getRequest()->getPost()) {
		if(!empty($data['to']) && !empty($data['from']))
		{
		    try
		    {
	 	    	$obj=new As_Inventory_Model_Sale();
	 	    	$obj->to=$data['to'];
	 	    	$obj->from=$data['from'];
	  	    	$pdf=$obj->getPdf();
	  	    	$this->_sendUploadResponse(time().'.pdf', $pdf, 'application/pdf');
	  	    }
	  	    catch(Exception $e)
	  	    {
	  	    	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                	Mage::getSingleton('adminhtml/session')->setFormData($data);
                	$this->_redirect('*/*/index');
	  	    }
	  	}
	  	else
	  	{
	  		Mage::getSingleton('adminhtml/session')->addError('Both dates are required.');
                	Mage::getSingleton('adminhtml/session')->setFormData($data);
	  		$this->_redirect('*/*/index');
	  	}
	 }
	}
	
    public function exportPdfAction()
    {
    	if ($data = $this->getRequest()->getPost()) {
    	
    	}
    
    }
   
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

}
