<?php

class Kirchbergerknorr_SeoGenerator_Helper_Rules extends Mage_Core_Helper_Abstract
{
    protected $_storeId;

    protected $_ruleType;

    protected $_categoryId;

    public function  getRules($param)
    {
        $ruleData = Mage::getModel('seogenerator/rules')->getCollection()
            ->addCategoryFilter($this->getCategoryId())
            ->addStoreFilter($this->getStoreId())->addActiveRule()->getData();
        if (isset($ruleData[0][$param])) {
            return $ruleData[0][$param];
        } else {
            return false;
        }
    }

    public function transformRulesToText($param, $categoryId, $storeId)
    {
        if (isset($storeId) && isset($categoryId)) {
            $this->setStoreId($storeId);
            $this->setCategoryId($categoryId);
        } else {
            Mage::getSingleton('core/session')->addError('error');
            return false;
        }

        $rules = $this->getRules($param);

        if (strlen($rules) > 0) {
            $helperTypeAttribute = Mage::helper('seogenerator/type_attribute');
            $helperTypeOptions = Mage::helper('seogenerator/type_options');
            $helperTypeAttribute->matchAttribute($rules);
            $_category = Mage::getModel('catalog/category')->load($this->getCategoryId());
            $_products = $_category->getProductCollection();
            $pattern = $helperTypeAttribute->createPatternAttribute();

            foreach ($_products->getAllIds() as $lol) {
                $_product = Mage::getModel('catalog/product')->load($lol);
                $replaceAttribute = $helperTypeAttribute->replaceAttributeInRules($rules, $_product);
                $text = $replaceAttribute;
                $text = $helperTypeOptions->replaceOptionsInRules($text, $_product);


                if ($param == 'rules_title') {
                    $_product->setMetaTitle($text)->save();
                }

                if ($param == 'rules_description') {

                    $_product->setMetaDescription($text)->save();
                }

                if ($param == 'rules_keywords') {
                    $_product->setMetaKeyword($text)->save();
                }
            }
        }
    }


    private function setStoreId($storeId)
    {
        $this->_storeId = $storeId;
    }

    public function getStoreId()
    {
        return $this->_storeId;
    }

    private function setCategoryId($categoryId)
    {
        $this->_categoryId = $categoryId;
    }

    public function getCategoryId()
    {
        return $this->_categoryId;
    }
}