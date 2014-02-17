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
class Kirchbergerknorr_SeoGenerator_Adminhtml_SeogeneratorController extends Mage_Adminhtml_Controller_Action
{

    public function createtagsAction()
    {
        $postRule = $this->getRequest()->getPost('rule');
        $postParam = $this->getRequest()->getPost('type');
        $storeId = $this->getRequest()->getParam('store', 0);

        if (sizeof($postParam) == 0 || sizeof($postParam) == 0) {
            Mage::getSingleton('core/session')->addError('Selected checkbox');
        } else {
            foreach ($postRule as $categoryId) {
                if (isset($postParam['rules_title']) && $postParam['rules_title'] == 1) {
                    Mage::helper('seogenerator/rules')->transformRulesToText('rules_title', $categoryId, $storeId);
                }

                if (isset($postParam['rules_description']) && $postParam['rules_description'] == 1) {
                    Mage::helper('seogenerator/rules')->transformRulesToText('rules_description', $categoryId, $storeId);
                }

                if (isset($postParam['rules_keywords']) && $postParam['rules_keywords'] == 1) {
                    Mage::helper('seogenerator/rules')->transformRulesToText('rules_keywords', $categoryId, $storeId);
                }
            };
            Mage::getSingleton('core/session')->addSuccess('Created');
        }
        $this->_redirect('*/seogenerator/edit');
    }

    public function createajaxtagAction()
    {

    }

    public function editAction()
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template', 'editmetatag', array('template' => 'seogenerator/edit.phtml'));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    public function viewrulesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('web/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }
}