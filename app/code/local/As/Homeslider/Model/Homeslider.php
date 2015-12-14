<?php

class As_Homeslider_Model_Homeslider extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('homeslider/homeslider');
    }
}