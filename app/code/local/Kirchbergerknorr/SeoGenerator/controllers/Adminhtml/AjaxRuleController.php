<?php

class Kirchbergerknorr_SeoGenerator_Adminhtml_AjaxRuleController extends Mage_Adminhtml_Controller_Action
{
    public function previewAction()
    {
        $productId = $this->getRequest()->getParam('id', false);
        $ruleId = $this->getRequest()->getParam('rule_id', false);
        $storeId = $this->getRequest()->getParam('store', 0);
        $this->loadLayout();

        if ($productId) {
            $text = Mage::helper('seogenerator/rules1')->previewTransformRuleToText(array('rules_title', 'rules_description', 'rules_keywords'), $productId, $ruleId, $storeId);
            $this->getResponse()->setBody($text);
        } else {
            return;
        }
    }

    public function getProductIdsAction()
    {
        $limit = $this->getRequest()->getParam('limit', false);
        $ruleId = $this->getRequest()->getParam('rule_id', false);
        $storeId = $this->getRequest()->getParam('store', 0);
        $_helperProduct = Mage::helper('seogenerator/product_prepare');

        if ($limit != false && $ruleId != false) {
            $model = Mage::getModel('seogenerator/rules')->load($ruleId);
            $categoryId = $model->getCategoryId();
            $productIdsCategory = $_helperProduct->getProductIds($categoryId, $limit);

            echo json_encode($productIdsCategory);

        } else {
            return;
        }
    }
}