<?php

class As_Inventory_Block_Adminhtml_Inventory_Column_Cost_Total extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{	
		//$cost =  (float) $row->getData('cost');
		//$qty =  (float) $row->getData('qty');
		$value=(float)$row->getData('total_cost');
		return number_format($value,2) ;
	}
}
?>
