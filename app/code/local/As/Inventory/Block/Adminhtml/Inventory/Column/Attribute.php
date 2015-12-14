<?php

class As_Inventory_Block_Adminhtml_Inventory_Column_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
	{	$helper=Mage::helper('inventory');
		$attibutes=$helper->getAttributes();
		$value =  $row->getData();
		$html=null;
		$values=array();
		$_product=Mage::getModel('catalog/product')->load($value['entity_id']);
		foreach($attibutes as $row)
		{	$code=$row['attribute_code'];
			$label=$row['frontend_label'];
			$txt=$_product->getAttributeText($code);
			if(!empty($txt))
			{
				$values[]=$label.':'.$txt;
			}
			//$txt='txt_'.$code;
			/*if(isset($value[$txt]) && !empty($value[$txt]))
			{
				$values[]=$label.':'.$value[$txt];
			}*/
		}
		$html=implode(', ',$values);
		return $html;
	}
}
?>
