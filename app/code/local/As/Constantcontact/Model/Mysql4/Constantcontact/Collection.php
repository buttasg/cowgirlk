<?php

class As_Constantcontact_Model_Mysql4_Constantcontact_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('constantcontact/constantcontact');
    }
}