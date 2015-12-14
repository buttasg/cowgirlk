<?php
class As_Brand_Block_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
	
    public function getPagerUrl($params=array())
    {	
        $innerParams = $this->getRequest()->getParams();
        $identifier = $innerParams['identifier'];
	$moduelUrl=$this->getUrl();
	$parentPath=parent::getPagerUrl($params);
            if(strpos($parentPath,'?')!==false)
            {	$parts=explode('?',$parentPath);
                    if(count($parts)==2)
                    {	$_helper=Mage::helper('brand');
                        $moduelUrl.=$_helper->getRoute().'/'.$identifier.'.html/';
                        $moduelUrl.='?'.$parts[1];
                    }
            }
        return $moduelUrl;
    }

}