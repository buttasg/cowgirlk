<?php

class As_Contactus_Model_Mysql4_Contactus extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the contactus_id refers to the key field in your database table.
        $this->_init('contactus/contactus', 'contactus_id');
    }
}