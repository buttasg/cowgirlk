<?php
/**
 * aheadWorks Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://ecommerce.aheadworks.com/AW-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This software is designed to work with Magento community edition and
 * its use on an edition other than specified is prohibited. aheadWorks does not
 * provide extension support in case of incorrect edition use.
 * =================================================================
 *
 * @category   AW
 * @package    AW_Mobile
 * @version    1.6.7
 * @copyright  Copyright (c) 2010-2012 aheadWorks Co. (http://www.aheadworks.com)
 * @license    http://ecommerce.aheadworks.com/AW-LICENSE.txt
 */


function updateValue(Mage_Eav_Model_Entity_Setup $setup, $entityTypeId, $code, $key, $value)
{
    $id = $setup->getAttribute($entityTypeId, $code, 'attribute_id');
    $setup->updateAttribute($entityTypeId, $id, $key, $value);
}

$installer = $this;


$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->removeAttribute('catalog_product', 'mobile_description');

$setup->addAttribute('catalog_product', 'mobile_description', array(
        'type'              => 'text',
        'backend'           => '',
        'frontend'          => '',
        'label'             => 'Mobile Description',
        'input'             => 'textarea',
        'class'             => '',
        'source'            => '',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible'           => true,
        'group'             => 'Mobile Options',
        'required'          => false,
        'user_defined'      => false,
        'default'           => '',
        'searchable'        => true,
        'filterable'        => false,
        'comparable'        => false,
        'is_wysiwyg_enabled'   => true,
        'is_html_allowed_on_front' => true,
        'visible_on_front'  => false,
        'visible_in_advanced_search' => false,
        'unique'            => false,
    ));

updateValue($setup, 'catalog_product', 'mobile_description', 'is_global', 0);
updateValue($setup, 'catalog_product', 'mobile_description', 'is_wysiwyg_enabled', true);
updateValue($setup, 'catalog_product', 'mobile_description', 'is_html_allowed_on_front', true);

$installer->endSetup();
