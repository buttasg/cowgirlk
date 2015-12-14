<?php

class As_Inventory_Model_Sale extends Mage_Sales_Model_Order_Pdf_Abstract 
{
    public $y;
    
    public $from;
    
    public $to;
    
    public function getPdf()
    {
    	    $pdf = new Zend_Pdf();
	    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
	    $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
	    $page->setFont($font, 12);
	    $width = $page->getWidth();
	    $i=0;
	    $this->insertLogo($page);
	    $this->insertAddress($page);
	    
	    /*$page->setFillColor(new Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
            $page->drawRectangle(25, $this->y + 15, 190, $this->y - 35);
            $page->drawRectangle(190, $this->y + 15, 350, $this->y - 35);
            $page->drawRectangle(350, $this->y + 15, 570, $this->y - 35);*/
	    
	    $page->setFont($font, 16);
	    
	    $this->y-=50;
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.5));
            $page->drawRectangle(25, $this->y + 15, 573, $this->y - 57);
            
            $page->setFillColor(new Zend_Pdf_Color_Html('#ffffff'));
            $headerText="Report: Net Sales & Tax";
            $page->drawText($headerText, 30, $this->y , 'UTF-8');
            $this->y-=22;
            $page->drawText("From: ".$this->from, 30, $this->y , 'UTF-8');
            $this->y-=22;
            $page->drawText("To: ".$this->to, 30, $this->y , 'UTF-8');
            
            $page->setFont($font, 14);
            
	    $this->y-=50;
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
            $totalText = Mage::helper('sales')->__('Total Net Sale');
            $page->drawText($totalText, 25, $this->y , 'UTF-8');
            $total=Mage::helper('core')->currency($this->getTotalSale(),true, false);
            $page->drawText($total, 505, $this->y , 'UTF-8');
	     
	    $this->y-=50;
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
            $totalText = Mage::helper('sales')->__('Net Sales Texas Only');
            $page->drawText($totalText, 25, $this->y , 'UTF-8');
            $total=Mage::helper('core')->currency($this->getTotalTexasSale(),true, false);
            $page->drawText($total, 505, $this->y , 'UTF-8');
            
            $this->y-=50;
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
            $totalText = Mage::helper('sales')->__('Net Shipping Costs for Texas only');
            $page->drawText($totalText, 25, $this->y , 'UTF-8');
            $total=Mage::helper('core')->currency($this->getTotalTexasShipping(),true, false);
            $page->drawText($total, 505, $this->y , 'UTF-8');
            
            $this->y-=50;
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
            $totalText = Mage::helper('sales')->__('Texas Net Sales Tax');
            $page->drawText($totalText, 25, $this->y , 'UTF-8');
            $total=Mage::helper('core')->currency($this->getTotalTexasTax(),true, false);
            $page->drawText($total, 505, $this->y , 'UTF-8');
	    
	    $pdf->pages[] = $page;
	    return $pdf->render();
    }
        
  
  
    public function getTotalSale()
    {
    	$resouce=Mage::getSingleton('core/resource');
    	$read=$resouce->getConnection('core_read');
    	$saleTable=$resouce->getTableName('sales/order');
    	$select=$read->select()->from(array('s'=>$saleTable),array('total_sale'=>new Zend_Db_Expr('SUM(s.grand_total)')));
    	$select->where('s.status=?','complete');
    	$select->where('s.created_at>=?',date('Y-m-d',strtotime($this->from)));
    	$select->where('s.created_at<=?',date('Y-m-d',strtotime($this->to)));
    	$totalSale=$read->fetchOne($select);
    	return $totalSale;
    }
    
    
    public function getTotalTexasSale()
    {
    	$resouce=Mage::getSingleton('core/resource');
    	$read=$resouce->getConnection('core_read');
    	$saleTable=$resouce->getTableName('sales/order');
    	$addressTable=$resouce->getTableName('sales/order_address');
    	$select=$read->select()->from(array('s'=>$saleTable),array('total_sale'=>new Zend_Db_Expr('SUM(s.grand_total)')));
    	$select->joinRight(array('a'=>$addressTable),'a.parent_id=s.entity_id',array());//shipping
    	$select->where("a.region='tx' OR a.region='texas'");
    	$select->where('a.address_type=?','shipping');
    	$select->where('s.status=?','complete');
    	$select->where('s.created_at>=?',date('Y-m-d',strtotime($this->from)));
    	$select->where('s.created_at<=?',date('Y-m-d',strtotime($this->to)));
    	$totalSale=$read->fetchOne($select);
    	
    	return $totalSale;
    }
    
    public function getTotalTexasShipping()
    {
    	$resouce=Mage::getSingleton('core/resource');
    	$read=$resouce->getConnection('core_read');
    	$saleTable=$resouce->getTableName('sales/order');
    	$addressTable=$resouce->getTableName('sales/order_address');
    	$select=$read->select()->from(array('s'=>$saleTable),array('total_shipping'=>new Zend_Db_Expr('SUM(s.shipping_amount)')));
    	$select->joinRight(array('a'=>$addressTable),'a.parent_id=s.entity_id',array());
    	$select->where("a.region='tx' OR a.region='texas'");
    	$select->where('a.address_type=?','shipping');
    	$select->where('s.status=?','complete');
    	$select->where('s.created_at>=?',date('Y-m-d',strtotime($this->from)));
    	$select->where('s.created_at<=?',date('Y-m-d',strtotime($this->to)));
    	$total=$read->fetchOne($select);
    	
    	return $total;
    }
    
    public function getTotalTexasTax()
    {
    	$resouce=Mage::getSingleton('core/resource');
    	$read=$resouce->getConnection('core_read');
    	$saleTable=$resouce->getTableName('sales/order');
    	$addressTable=$resouce->getTableName('sales/order_address');
    	$select=$read->select()->from(array('s'=>$saleTable),array('total_tax'=>new Zend_Db_Expr('SUM(s.tax_amount)')));
    	$select->joinRight(array('a'=>$addressTable),'a.parent_id=s.entity_id',array());
    	$select->where("a.region='tx' OR a.region='texas'");
    	$select->where('a.address_type=?','shipping');
    	$select->where('s.status=?','complete');
    	$select->where('s.created_at>=?',date('Y-m-d',strtotime($this->from)));
    	$select->where('s.created_at<=?',date('Y-m-d',strtotime($this->to)));
    	$total=$read->fetchOne($select);
    	
    	return $total;
    }
    
    protected function insertLogo(&$page, $store = null)
    {
        $this->y = $this->y ? $this->y : 815;
        $image = Mage::getStoreConfig('sales/identity/logo', $store);
        if ($image) {
            $image = Mage::getBaseDir('media') . '/sales/store/logo/' . $image;
            if (is_file($image)) {
                $image       = Zend_Pdf_Image::imageWithPath($image);
                $top         = 830; //top border of the page
                $widthLimit  = 270; //half of the page width
                $heightLimit = 270; //assuming the image is not a "skyscraper"
                $width       = $image->getPixelWidth();
                $height      = $image->getPixelHeight();

                //preserving aspect ratio (proportions)
                $ratio = $width / $height;
                if ($ratio > 1 && $width > $widthLimit) {
                    $width  = $widthLimit;
                    $height = $width / $ratio;
                } elseif ($ratio < 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $height * $ratio;
                } elseif ($ratio == 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $widthLimit;
                }

                $y1 = $top - $height;
                $y2 = $top;
                $x1 = 25;
                $x2 = $x1 + $width;

                //coordinates after transformation are Mage::helper'core'->currencyed by Zend
                $page->drawImage($image, $x1, $y1, $x2, $y2);

                $this->y = $y1 - 10;
            }
        }
    }
    
  
    protected function insertAddress(&$page, $store = null)
    {
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
        $font = $this->_setFontRegular($page, 10);
        $page->setLineWidth(0);
        $this->y = $this->y ? $this->y : 815;
        $top = 815;
        foreach (explode("\n", Mage::getStoreConfig('sales/identity/address', $store)) as $value){
            if ($value !== '') {
                $value = preg_replace('/<br[^>]*>/i', "\n", $value);
                foreach (Mage::helper('core/string')->str_split($value, 45, true, true) as $_value) {
                    $page->drawText(trim(strip_tags($_value)),
                        $this->getAlignRight($_value, 130, 440, $font, 10),
                        $top,
                        'UTF-8');
                    $top -= 10;
                }
            }
        }
        $this->y = ($this->y > $top) ? $top : $this->y;
    }

    protected function _formatAddress($address)
    {
        $return = array();
        foreach (explode('|', $address) as $str) {
            foreach (Mage::helper('core/string')->str_split($str, 45, true, true) as $part) {
                if (empty($part)) {
                    continue;
                }
                $return[] = $part;
            }
        }
        return $return;
    }

    protected function _calcAddressHeight($address)
    {
        $y = 0;
        foreach ($address as $value){
            if ($value !== '') {
                $text = array();
                foreach (Mage::helper('core/string')->str_split($value, 55, true, true) as $_value) {
                    $text[] = $_value;
                }
                foreach ($text as $part) {
                    $y += 15;
                }
            }
        }
        return $y;
    }
    
    protected function _setFontRegular($object, $size = 7)
    {
        $font = Zend_Pdf_Font::fontWithPath(Mage::getBaseDir() . '/lib/LinLibertineFont/LinLibertine_Re-4.4.1.ttf');
        $object->setFont($font, $size);
        return $font;
    }
}
