<?php

class As_Homeslider_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('homeslider')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('homeslider')->__('Disabled')
        );
    }
}