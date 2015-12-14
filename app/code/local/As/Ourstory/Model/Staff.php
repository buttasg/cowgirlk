<?php

class As_Ourstory_Model_Staff extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ourstory/staff');
    }
}