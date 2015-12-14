<?php
/**
 * Urlrewriteexport.php
 * CommerceExtensions @ InterSEC Solutions LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.commerceextensions.com/LICENSE-M1.txt
 *
 * @category   REWRITE
 * @package    Urlrewriteexport
 * @copyright  Copyright (c) 2003-2010 CommerceExtensions @ InterSEC Solutions LLC. (http://www.commerceextensions.com)
 * @license    http://www.commerceextensions.com/LICENSE-M1.txt
 */ 
 
class CommerceExtensions_Urlrewritesimportexport_Model_Convert_Parser_Urlrewriteexport extends Mage_Eav_Model_Convert_Parser_Abstract
{
/**
     * @deprecated not used anymore
     */
    public function parse()
    {
			return $this;
		}
 /**
     * Unparse (prepare data) loaded categories
     *
     * @return Mage_Catalog_Model_Convert_Adapter_Customerreviewexport
     */
    public function unparse()
    {
				 $ByStoreID = $this->getVar('store');
				 $resource = Mage::getSingleton('core/resource');
				 $prefix = Mage::getConfig()->getNode('global/resources/db/table_prefix');
				 $read = $resource->getConnection('core_read');
				 $row = array();
				 $finalstoreidsforexport="";
				 
				 	if($ByStoreID != "") {
				 		$select_qry = "SELECT store_id,category_id,product_id,id_path,request_path,target_path,is_system,options,description FROM ".$prefix."core_url_rewrite WHERE store_id = '".$ByStoreID."'";
					} else {
				 		$select_qry = "SELECT store_id,category_id,product_id,id_path,request_path,target_path,is_system,options,description FROM ".$prefix."core_url_rewrite";
					}
				 
					$rows = $read->fetchAll($select_qry);
					foreach($rows as $data)
					 { 
					 
					 			$row["store_id"] = $data['store_id'];
					 			$row["category_id"] = $data['category_id'];
								if($this->getVar('urlrewrites_by_sku') == "true") {
									if($data['product_id'] != "") {
										$productModel = Mage::getModel('catalog/product')->load($data['product_id']); 
										$row["product_sku"] = $productModel->getSku();
									}
								} else {
					 					$row["product_id"] = $data['product_id'];
								}
					 			$row["id_path"] = $data['id_path'];
					 			$row["request_path"] = $data['request_path'];
					 			$row["target_path"] = $data['target_path'];
					 			$row["is_system"] = $data['is_system'];
					 			$row["options"] = $data['options'];
					 			$row["description"] = $data['description'];
								
					 			$batchExport = $this->getBatchExportModel()
                ->setId(null)
                ->setBatchId($this->getBatchModel()->getId())
                ->setBatchData($row)
                ->setStatus(1)
                ->save();
					 }
					 
					 
        return $this;
		}
}

?>