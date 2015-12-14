<?php

class As_Contactus_Model_Contactus extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('contactus/contactus');
    }
}