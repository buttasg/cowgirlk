<?php

class As_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('brand/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Brands Manager'), Mage::helper('adminhtml')->__('Brand Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('brand/brand')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('brand_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('brand/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand Manager'), Mage::helper('adminhtml')->__('Brand Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand News'), Mage::helper('adminhtml')->__('Brand News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand_edit'))
				->_addLeft($this->getLayout()->createBlock('brand/adminhtml_brand_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Brand does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
			if ($data = $this->getRequest()->getPost()) {
			
					if($data['filename']['delete']=="1")
			  		{	$path = Mage::getBaseDir('media') . DS.$data['filename']['value'] ;
			  			$data['filename']=null;
			  			if(file_exists($path))
			  			   @unlink($path);
			 
			  		}
			  		
			  		if($data['filename']['delete']!="1")
			  		{
			  			$data['filename']=$data['filename']['value'];
			 
			  		}
			
			
				if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
					try {	
						/* Starting upload */	
						$uploader = new Varien_File_Uploader('filename');
					
						// Any extention would work
			   		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
						$uploader->setAllowRenameFiles(false);
					
						// Set the file upload mode 
						// false -> get the file directly in the specified folder
						// true -> get the file in the product like folders 
						//	(file.jpg will go in something like /media/f/i/file.jpg)
						$uploader->setFilesDispersion(false);
							
						// We set media as the upload dir
						$path = Mage::getBaseDir('media') . DS ;
						$uploader->save($path, $_FILES['filename']['name'] );
						$data['filename']=$_FILES['filename']['name'] ;
					} catch (Exception $e) {
			      
				}
			
				//this way the name is saved in DB
		  			//$data['filename'] = $_FILES['filename']['name'];
				}
		  			
		  			
				$model = Mage::getModel('brand/brand');
				$brandId=(int)$this->getRequest()->getParam('id');
				$model->setData($data);
				$model->setId($brandId);
			
				try {
					if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
						$model->setCreatedTime(now())
							->setUpdateTime(now());
					} else {
						$model->setUpdateTime(now());
					}	
					$title=trim($data['title']);
					if(empty($title))
					{
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Title is required.'));
						$this->_redirect('*/*/edit', array('id' => $model->getId()));
						return;
					}
					else
					{	$url=Mage::helper('brand')->createUrl($title);
						$data['url']=$url;
					}
					$resource = Mage::getSingleton('core/resource');
					$adapter=$resource->getConnection('core_write');
					$table=$resource->getTableName('brand/brand');
					$saveIt=true;
					if($brandId==0)
					{	$select = $adapter->select()
						->from(array('brand_table' =>$table), array('*'))
						->where("brand_table.title = ?", $title);
						$row=$adapter->fetchRow($select);
						if($row){
							Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Brand name already exists.'));
							$this->_redirect('*/*/edit', array('id' => $model->getId()));
							$saveIt=false;
							return;
						}
						else
						{	$data['content']=$title;
							$model->setData($data);
							$model->save();
							Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved.'));
							Mage::getSingleton('adminhtml/session')->setFormData(false);
							$this->_redirect('*/*/edit', array('id' => $model->getId()));
							return;
					
						}
					}
				
					if($brandId>0)
					{	$select = $adapter->select()
						->from(array('brand_table' =>$table), array('*'))
						->where("brand_table.title = ?", $title)
						->where("brand_table.brand_id!=?", $brandId);
						$row=$adapter->fetchRow($select);
					
						if($row)
						{
							Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Brand name already exists.'));
							$this->_redirect('*/*/edit', array('id' => $model->getId()));
							$saveIt=false;
							return;
						}
						else
						{	
							/*$model->setId($brandId);
							$model->setData($data);
							$model->save();*/
							$update=array();
							$update['title']=$title;
							$update['filename']=$data['filename'];
							$update['url']=$data['url'];
							$update['status']=$data['status'];
							$update['home_page']=$data['home_page'];
							$update['content']=$title;
							$where=array();
							$where['brand_id=?']=$brandId;
							$adapter->update($table,$update,$where);
							Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved.'));
							Mage::getSingleton('adminhtml/session')->setFormData(false);
						}
					}
					/*if($saveIt)
					{
						$model->setData($data);
						$model->save();
						Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved.'));
						Mage::getSingleton('adminhtml/session')->setFormData(false);
					}*/
					if ($this->getRequest()->getParam('back')) {
						$this->_redirect('*/*/edit', array('id' => $model->getId()));
						return;
					}
					$this->_redirect('*/*/');
					return;
		    } catch (Exception $e) {
		        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		        Mage::getSingleton('adminhtml/session')->setFormData($data);
		        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
		        return;
		    }
		}
        	Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Unable to find Brand to save'));
        	$this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('brand/brand');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $brandIds = $this->getRequest()->getParam('brand');
        if(!is_array($brandIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select brand(s)'));
        } else {
            try {
                foreach ($brandIds as $brandId) {
                    $brand = Mage::getModel('brand/brand')->load($brandId);
                    $brand->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($brandIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $brandIds = $this->getRequest()->getParam('brand');
        if(!is_array($brandIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select brand(s)'));
        } else {
            try {
                foreach ($brandIds as $brandId) {
                    $brand = Mage::getSingleton('brand/brand')
                        ->load($brandId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($brandIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'brand.csv';
        $content    = $this->getLayout()->createBlock('brand/adminhtml_brand_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'brand.xml';
        $content    = $this->getLayout()->createBlock('brand/adminhtml_brand_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
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
