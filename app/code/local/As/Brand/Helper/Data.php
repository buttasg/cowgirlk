<?php

class As_Brand_Helper_Data extends Mage_Core_Helper_Abstract
{
        public function createUrl($text)
        {
            $text=preg_replace('/\s+/',' ',$text);
            $text=preg_replace('/[^a-zA-Z0-9]/','-',$text);
            return strtolower($text);
        }

        public function getRoute()
        {
            $route = "brands";
            return $route;
        }

        public function getBrandsUrl()
        {       
            $route = "brands.html";
            return $route;

        }

        public function getUrl($identifier)
        {    $url=$this->getRoute().'/'.$identifier.'.html';
             $url = Mage::getUrl($url);
            return $url;
        }
        
        public function getHomeBrands()
        {
            $resource = Mage::getSingleton('core/resource');
            $read= $resource->getConnection('core_read');
            $brandTable = $resource->getTableName('brand');

            $select = $read->select()
               ->from($brandTable,array('*'))
               ->where('status=?',1)
               ->where('home_page=?',1)
               ->order('title') ;

            $brands = $read->fetchAll($select);
            return $brands;
        }
}
