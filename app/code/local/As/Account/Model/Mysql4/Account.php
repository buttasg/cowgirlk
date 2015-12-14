<?php

class As_Account_Model_Mysql4_Account extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the account_id refers to the key field in your database table.
        $this->_init('account/account', 'account_id');
    }
}