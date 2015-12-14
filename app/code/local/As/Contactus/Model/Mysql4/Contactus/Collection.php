<?php

class As_Contactus_Model_Mysql4_Contactus_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('contactus/contactus');
    }
}