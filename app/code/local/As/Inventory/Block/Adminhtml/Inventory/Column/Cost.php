<?php

class As_Inventory_Block_Adminhtml_Inventory_Column_Cost extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{	
		$value =  (float) $row->getData('cost');
		return number_format($value,2) ;
	}
}
?>
