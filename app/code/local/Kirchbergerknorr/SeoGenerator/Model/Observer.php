<?php

class Kirchbergerknorr_SeoGenerator_Model_Observer
{
    public function loadRules($observer)
    {
        $category = $observer->getEvent()->getCategory();
        $storeId = $category->getStoreId();
        $categoryId = $category->getId();

        if (isset($categoryId) && $categoryId > 0) {
            $collection = Mage::getModel('seogenerator/rules')->getCollection()->addCategoryFilter($categoryId)->addStoreFilter($storeId)->getData();
            if (sizeof($collection) > 0) {
                $category->setRulesData($collection[0]);
            }
        }

        return $this;
    }

    public function addTab($observer)
    {
        $category = $observer->getEvent()->getTabs();
        $category->addTab('feature', array(
            'label' => Mage::helper('catalog')->__('SEO Rules'),
            'content' => Mage::app()->getLayout()->createBlock('seogenerator/adminhtml_tab')->toHtml(),
        ));

        return $category;

    }

    public function prepareSave($observer)
    {

        $request = $observer->getEvent()->getRequest();
        $data = $request->getPost('rules_seo');
        $category = $observer->getEvent()->getCategory();

        if ($data) {
            $category->setRulesData(new Varien_Object($data));
        }
        return $this;
    }

    public function afterSave($observer)
    {
        $category = $observer->getEvent()->getCategory();
        $storeId = $category->getStoreId();
        $categoryId = $category->getId();

        $collection = Mage::getModel('seogenerator/rules')->getCollection()->addCategoryFilter($categoryId)->addStoreFilter($storeId)->getData();

        if (sizeof($collection) > 0) {
            if ($data = $category->getRulesData()->getData()) {
                $rulesId = $collection[0]['rules_id'];
                $model = Mage::getModel('seogenerator/rules')->load($rulesId)->addData($data);
                try {
                    $model->setId($rulesId)->save();
                } catch (Exception $e) {
                    Mage::getSingleton('core/session')->addError($e->getMessage());
                }

            }
        } else {
            if ($data = $category->getRulesData()->getData()) {
                $saveRules = Mage::getModel('seogenerator/rules')->setData($data)->setData('category_id', $categoryId)->setData('store_id', $storeId)->save();
            }
        }
        return $this;
    }

    public function deleteAfter($observer)
    {
        $category = $observer->getEvent()->getCategory();
        $categoryId = $category->getId();
        $model = Mage::getModel('seogenerator/rules');
        try {
            $model->setId($categoryId)->delete();

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }

        return $this;
    }
}