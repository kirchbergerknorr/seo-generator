<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category Kirchbergerknorr
 * @package Kirchbergerknorr_SeoGenerator
 * @copyright Copyright (c) 2014 Kirchbergerknorr
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Kirchbergerknorr_SeoGenerator_Model_Mysql4_Rules_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('seogenerator/rules');
    }

    public function addCategoryFilter($category_id)
    {
        $this->getSelect()
            ->where('category_id = ?', $category_id);
        return $this;
    }

    public function addRuleFilter($rule_id)
    {
        $this->getSelect()
            ->where('rules_id = ?', $rule_id);
        return $this;
    }

    public function addStoreFilter($store_id)
    {
        $this->getSelect()
            ->where('store_id = ?', $store_id);
        return $this;
    }


    public function addActiveRule()
    {
        $this->getSelect()
            ->where('rules_active = 1');
        return $this;
    }

    public function joinCategory()
    {
        $this->getSelect()
            ->join(array(
                    'table_alias' => Mage::getSingleton('core/resource')->getTableName('catalog_category_entity_varchar')),
                'main_table.category_id = table_alias.entity_id',
                array('category_name' => 'table_alias.value'))->where('table_alias.attribute_id = 41');;
        return $this;
    }
}