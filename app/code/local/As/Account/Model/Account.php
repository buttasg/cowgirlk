<?php

class As_Account_Model_Account extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('account/account');
    }
}