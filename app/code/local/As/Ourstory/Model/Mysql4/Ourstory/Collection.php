<?php

class As_Ourstory_Model_Mysql4_Ourstory_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ourstory/ourstory');
    }
}