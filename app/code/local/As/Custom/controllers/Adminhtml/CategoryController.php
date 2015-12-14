<?php
require_once('app/code/core/Mage/Adminhtml/controllers/Catalog/CategoryController.php');

class As_Custom_Adminhtml_CategoryController extends Mage_Adminhtml_Catalog_CategoryController
{
	
    public function deleteAction()
    {
    	   if ($id = (int) $this->getRequest()->getParam('id')) {
            try {
                $category = Mage::getModel('catalog/category')->load($id);
                Mage::dispatchEvent('catalog_controller_category_delete', array('category'=>$category));

                Mage::getSingleton('admin/session')->setDeletedPath($category->getPath());

                $category->delete();
                
                Mage::dispatchEvent('catalog_controller_category_delete_after', array('category'=>$category));
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('catalog')->__('The category has been deleted.'));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->getResponse()->setRedirect($this->getUrl('*/*/edit', array('_current'=>true)));
                return;
            }
            catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('catalog')->__('An error occurred while trying to delete the category.'));
                $this->getResponse()->setRedirect($this->getUrl('*/*/edit', array('_current'=>true)));
                return;
            }
        }
        $this->getResponse()->setRedirect($this->getUrl('*/*/', array('_current'=>true, 'id'=>null)));
    
    }
}
