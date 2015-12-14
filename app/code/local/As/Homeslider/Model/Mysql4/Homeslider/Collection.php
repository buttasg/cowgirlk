<?php

class As_Homeslider_Model_Mysql4_Homeslider_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('homeslider/homeslider');
    }
}