<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'brand', array(
	'group'         => 'General',
        'backend'       => '',
        'frontend'      => '',
        'class' => '',
        'default'       => '',
        'label' => 'Brand',
        'input' => 'select',
        'type'  => 'int',
        'source'        => 'brand/brand_attribute_source_brand',
        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'       => 1,
        'required'      => 0,
        'searchable'    => 1,
        'filterable'    => 1,
        'unique'        => 0,
        'comparable'    => 0,
        'visible_on_front' => 1,
        'is_html_allowed_on_front' => 1,
        'user_defined'  => 1,
	'apply_to'      => 'simple,configurable',
	'used_for_sort_by' => 0,
));

/*$installer->addAttribute('catalog_category', 'brand', array(
		'group'         => 'General Information',
        'backend'       => 'eav/entity_attribute_backend_array',
        'frontend'      => '',
        'class' => '',
        'default'       => '',
        'label' 		=> 'Brand',
        'input' 		=> 'multiselect',
        'type'          => 'varchar',
        'source'        => 'brand/brand_attribute_source_brand',
        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'       => 1,
        'required'      => 0,
        'searchable'    => 1,
        'filterable'    => 1,
        'unique'        => 0,
        'comparable'    => 0,
        'visible_on_front' => 1,
        'is_html_allowed_on_front' => 1,
        'user_defined'  => 1,
	'used_for_sort_by' => 0,
));*/

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('brand')};
CREATE TABLE {$this->getTable('brand')} (
  `brand_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `home_page` smallint(6) NOT NULL default '2',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 