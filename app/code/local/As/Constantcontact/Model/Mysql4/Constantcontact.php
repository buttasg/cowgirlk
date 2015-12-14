<?php

class As_Constantcontact_Model_Mysql4_Constantcontact extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the constantcontact_id refers to the key field in your database table.
        $this->_init('constantcontact/constantcontact', 'constantcontact_id');
    }
}