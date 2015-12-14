<?php

class As_Contactus_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getOptions()
	{
		$arr=array();
		
		$arr["1"]=Mage::helper('contacts')->__('I have a general question?');
		$arr["2"]=Mage::helper('contacts')->__('I have a question about my account?');
		$arr["3"]=Mage::helper('contacts')->__('I have a question about my order?');;
		$arr["4"]=Mage::helper('contacts')->__('I have a technical website question?');
		
		return $arr;
	}
}
