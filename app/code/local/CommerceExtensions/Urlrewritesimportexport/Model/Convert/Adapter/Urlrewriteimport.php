<?php
/**
 * Urlrewriteimport.php
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
 * @package    Urlrewriteimport
 * @copyright  Copyright (c) 2003-2010 CommerceExtensions @ InterSEC Solutions LLC. (http://www.commerceextensions.com)
 * @license    http://www.commerceextensions.com/LICENSE-M1.txt
 */ 
 
class CommerceExtensions_Urlrewritesimportexport_Model_Convert_Adapter_Urlrewriteimport extends Mage_Eav_Model_Convert_Adapter_Entity
{
    protected $_stores;

    public function parse()
    {
        $batchModel = Mage::getSingleton('dataflow/batch');
        /* @var $batchModel Mage_Dataflow_Model_Batch */

        $batchImportModel = $batchModel->getBatchImportModel();
        $importIds = $batchImportModel->getIdCollection();

        foreach ($importIds as $importId) {
            //print '<pre>'.memory_get_usage().'</pre>';
            $batchImportModel->load($importId);
            $importData = $batchImportModel->getBatchData();

            $this->saveRow($importData);
        }
    }

    /**
     * Save URL REWRITES (import)
     *
     * @param array $importData
     * @throws Mage_Core_Exception
     * @return bool
     */
    public function saveRow(array $importData)
    {
				 $typeofcsv = $this->getVar('typeofcsv');
				 #print_r($importData);
				 
				 if($typeofcsv == "simplefile") {
				// [START] - SIMPLE CSV IMPORT - [START] 
				
				 $resource = Mage::getSingleton('core/resource');
				 $prefix = Mage::getConfig()->getNode('global/resources/db/table_prefix'); 
				 $write = $resource->getConnection('core_write');
				 $read = $resource->getConnection('core_read');
				 $url_rewrite_id="";
				 $update = "false";
				 $get_url_rewrite_id_qry = "SELECT url_rewrite_id FROM `".$prefix."core_url_rewrite` WHERE request_path = '".trim($importData['old_url'])."'";
				 $get_url_rewrite_id_rows = $read->fetchAll($get_url_rewrite_id_qry);
					foreach($get_url_rewrite_id_rows as $data_url_rewrite_id)
					{ 
						 $url_rewrite_id = $data_url_rewrite_id['url_rewrite_id'];
						 if($url_rewrite_id !="") {
						 $update = "true";
						 // UPDATE URL REWRITE
						 $write->query("Update `".$prefix."core_url_rewrite` SET target_path = '".$importData['new_url']."' WHERE url_rewrite_id = '" .$url_rewrite_id."'");
						 }
					}
					
					if($update != "true") {
							// INSERT URL REWRITE
						//$write->query("Insert into `".$prefix."core_url_rewrite` (store_id,category_id,product_id,id_path,request_path,target_path,is_system,options,description) VALUES ('0',NULL,NULL,'".$importData['old_url']."','".$importData['old_url']."','".$importData['new_url']."','0','".$importData['options']."','')");
						 $write->query("Insert into `".$prefix."core_url_rewrite` (store_id,category_id,product_id,id_path,request_path,target_path,is_system,options,description) VALUES ('0',NULL,NULL,'".$importData['old_url']."','".$importData['old_url']."','".$importData['new_url']."','0','RP','')");
					}
				// [END] - SIMPLE CSV IMPORT - [END] 
					
				} else {
				// [START] - FULL CSV IMPORT - [START] 
				
					   $resource = Mage::getSingleton('core/resource');
						 $prefix = Mage::getConfig()->getNode('global/resources/db/table_prefix'); 
						 $write = $resource->getConnection('core_write');
						 $read = $resource->getConnection('core_read');
						 $url_rewrite_id="";
						 $update = "false";
						 if($importData['category_id'] != "") {
						  	$category_id = "'".$importData['category_id']."'";
						 } else {
						 		$category_id = 'NULL';
						 }
						 if(isset($importData['product_id'])) {
							 if($importData['product_id'] != "") {
								$product_id = "'".$importData['product_id']."'";
							 } else {
								$product_id = 'NULL';
							 }
						 }
						 if(isset($importData['product_sku'])) {
							 if($importData['product_sku'] != "") {
								$productModel = Mage::getModel('catalog/product')->loadByAttribute('sku',$importData['product_sku']); 
								$product_id = $productModel->getId();
							 } else {
								$product_id = 'NULL';
							 }
						 }
						 if($product_id != "" && $product_id != 'NULL') {
						 $get_url_rewrite_id_qry = "SELECT url_rewrite_id FROM `".$prefix."core_url_rewrite` WHERE request_path = '".trim($importData['request_path'])."' AND store_id = '".$importData['store_id']."' AND product_id = '".$product_id."'";
						 } else {
						 $get_url_rewrite_id_qry = "SELECT url_rewrite_id FROM `".$prefix."core_url_rewrite` WHERE request_path = '".trim($importData['request_path'])."' AND store_id = '".$importData['store_id']."' AND is_system = '0' AND options = 'RP'";
						 }
						 $get_url_rewrite_id_rows = $read->fetchAll($get_url_rewrite_id_qry);
							foreach($get_url_rewrite_id_rows as $data_url_rewrite_id)
							{ 
								 $url_rewrite_id = $data_url_rewrite_id['url_rewrite_id'];
								 if($url_rewrite_id !="") {
								 $update = "true";
								 // UPDATE URL REWRITE
								 $write->query("Update `".$prefix."core_url_rewrite` SET target_path = '".$importData['target_path']."' WHERE url_rewrite_id = '" .$url_rewrite_id."'");
								 }
							}
							
							if($update != "true") {
									// INSERT URL REWRITE
								 $write->query("Insert into `".$prefix."core_url_rewrite` (store_id,category_id,product_id,id_path,request_path,target_path,is_system,options,description) VALUES ('".$importData['store_id']."',".$category_id.",".$product_id.",'".$importData['id_path']."','".$importData['request_path']."','".$importData['target_path']."','".$importData['is_system']."','".$importData['options']."','".$importData['description']."')");
							}
				
				// [END] - FULL CSV IMPORT - [END] 
				}
			
        return true;
    }

}

?>