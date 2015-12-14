<?php

class Wyomind_Watchlog_Adminhtml_AdvancedController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("watchlog/watchlog")->_addBreadcrumb(Mage::helper("adminhtml")->__("Watchlog Manager"), Mage::helper("adminhtml")->__("Watchlog Manager"));
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__("Watchlog"));
        $this->_title($this->__("Manager Watchlog"));

        $this->_initAction();
        $this->renderLayout();
    }
    
    public function purgeAction() {
        $log = Mage::helper('watchlog')->purgeData();
        $this->_redirect('*/*');
    }



}
