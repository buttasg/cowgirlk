<?php
class As_Topmenu_Block_Topmenu extends Mage_Page_Block_Html_Topmenu
{
    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param Varien_Data_Tree_Node $menuTree
     * @param string $childrenWrapClass
     * @return string
     */
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';
	$brandCategoryId=Mage::getStoreConfig('brand/brand/category_id');
	$_helperBrands = Mage::helper('brand');
	$brandUrl=Mage::getUrl($_helperBrands->getBrandsUrl());
        foreach ($children as $child) {

            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            $categoryId=str_replace("category-node-","",$child->getId());
            $url=($categoryId==$brandCategoryId)?$brandUrl:$child->getUrl();
            $html .= '<a href="' . $url. '" ' . $outermostClassCode . '><span>'
                . $this->escapeHtml($child->getName()) . '</span></a>';

            if ($child->hasChildren()) {
                if (!empty($childrenWrapClass)) {
                    $html .= '<div class="' . $childrenWrapClass . '">';
                }
                
                $html .= '<ul class="level' . $childLevel . '">';
                	/*if($childLevel==0)
                	{
                  	 $html .= '<div class="submenu">';
                	}*/
                $html .= $this->_getHtml($child, $childrenWrapClass);
                	/*if($childLevel==0)
		        {
		          $html .= '</div>';
		        }*/
                $html .= '</ul>';
		
                if (!empty($childrenWrapClass)) {
                    $html .= '</div>';
                }
            }
            $html .= '</li>';

            $counter++;
        }

        return $html;
    }
}
