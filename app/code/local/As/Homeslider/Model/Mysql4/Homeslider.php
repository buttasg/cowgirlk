<?php

class As_Homeslider_Model_Mysql4_Homeslider extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the homeslider_id refers to the key field in your database table.
        $this->_init('homeslider/homeslider', 'homeslider_id');
    }
}