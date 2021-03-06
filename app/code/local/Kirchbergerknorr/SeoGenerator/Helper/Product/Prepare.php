<?php

class Kirchbergerknorr_SeoGenerator_Helper_Product_Prepare extends Mage_Core_Helper_Abstract
{
    public function  getProductIds($productId, $limit = false)
    {
        $collection = Mage::getModel('catalog/category')->load($productId)->getProductCollection()->setPageSize($limit);
        $result = array();

        foreach ($collection as $product) {
            $result[] = $product->getId();
        }

        return $result;
    }

    public function getProductCollection($arrayProductIds, $limit = false)
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('entity_id', array('in' => $arrayProductIds))
            ->addAttributeToFilter('visibility', array('neq' => '1'))
            ->addAttributeToFilter('status', array('eq' => '1'))
            ->addAttributeToSelect('*');
        if ($limit) {
            $collection->setPageSize($limit);
        }
        return $collection;
    }
}