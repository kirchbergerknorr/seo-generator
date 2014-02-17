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
class Kirchbergerknorr_SeoGenerator_Block_Popular extends Mage_Adminhtml_Block_Catalog_Form
{

    public function getProduct()
    {
        return Mage::registry('product');
    }

    public function getConvertedText()
    {
        $helperRules = Mage::helper('seogenerator/rules');

        $helperTypeAttribute = Mage::helper('seogenerator/type_attribute');

        $helperTypeOptions = Mage::helper('seogenerator/type_options');
        $rules = $this->getRules('rules_popular_options');
        $helperTypeAttribute->matchAttribute($rules);
        $_product = $this->getProduct();

        $replaceAttribute = $helperTypeAttribute->replaceAttributeInRules($rules, $_product);
        $text = $replaceAttribute;
        $text = $helperTypeOptions->replaceOptionsInRules($text, $_product);

        $text = preg_replace('/CT/', '', $text);

        return $this->replaceCategory($text);

    }

    public function replaceCategory($text)
    {
        $catNameStr = Mage::registry('current_category')->getName();

        if (substr($catNameStr, -1) == 's') {
            $catNameStr = substr($catNameStr, 0, strlen($catNameStr) - 1);
        }
        $result = preg_replace('/\%\%category\%\%/i', $catNameStr, $text);
        return $result;
    }

    public function  getRules($param)
    {
        $ruleData = Mage::getModel('seogenerator/rules')->getCollection()
            ->addCategoryFilter(Mage::registry('current_category')->getId())
            ->addStoreFilter(0)->addActiveRule()->getData();

        if (isset($ruleData[0][$param])) {
            return $ruleData[0][$param];
        } else {
            return false;
        }
    }
}