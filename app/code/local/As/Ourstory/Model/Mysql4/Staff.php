<?php

class As_Ourstory_Model_Mysql4_Staff extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the ourstory_id refers to the key field in your database table.
        $this->_init('ourstory/staff', 'staff_id');
    }
}