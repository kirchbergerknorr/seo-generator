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
class Kirchbergerknorr_SeoGenerator_Adminhtml_SeorulesController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('catalog/edittag1');
        $this->renderLayout();
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $collection = Mage::getModel('seogenerator/rules')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('seogenerator_rules', $model);

            $this->loadLayout();
            $this->_setActiveMenu('catalog/edittag1');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->_addContent($this->getLayout()->createBlock('seogenerator/adminhtml_seo_edit'))
                ->_addLeft($this->getLayout()->createBlock('seogenerator/adminhtml_seo_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('seogenerator')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        $session = Mage::getSingleton('adminhtml/session');

        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('seogenerator/rules');


            if ($id = $this->getRequest()->getParam('rules_id')) {
                try {
                    $model->load($id)->addData($data['rules_seo'])->setId($id)->save();
                    $this->_redirect('*/*/edit', array('id' => $id));
                    Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Rule was successfully saved'));
                    $this->_redirect('*/*/edit', array('id' => $id));
                } catch (Exception $e) {
                    Mage::getSingleton('core/session')->addError($e->getMessage());
                    $this->_redirect('*/*/edit', array('id' => $id));
                }
            } else {
                Mage::getSingleton('core/session')->addError('Error Saving');
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
    }

    public function massDeleteAction()
    {
        $rulesIds = $this->getRequest()->getParam('seo_rules_form');

        if (!is_array($rulesIds)) {
            $this->_getSession()->addError($this->__('Please select rule(s).'));
        } else {
            if (!empty($rulesIds)) {
                try {
                    foreach ($rulesIds as $ruleId) {

                        Mage::getModel('seogenerator/rules')->setId($ruleId)->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($rulesIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }


    public function massGenerateAction()
    {
        $data = $this->getRequest()->getPost();
    }

    public function massPreviewAction()
    {
        $data = $this->getRequest()->getPost();
    }


    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                Mage::getModel('seogenerator/rules')->setId($id)->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Rule was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }

        $this->_redirect('*/*/');
    }

    public function newAction()
    {
        $this->_redirect('*/catalog_category/index');
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('seogenerator/adminhtml_seo_grid')->toHtml()
        );
    }
}