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
class Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Tab extends Mage_Adminhtml_Block_Catalog_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setShowGlobalIcon(true);
    }

    public function getCategory()
    {
        if (!$this->_category) {
            $this->_category = Mage::registry('category');
        }
        return $this->_category;
    }

    public function _prepareLayout()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset',
            array('legend' => Mage::helper('seogenerator')->__('Meta tags Templates'))
        );

        $fieldset->addField('rules_active', 'select', array(
            'label' => Mage::helper('catalog')->__('Is Active'),
            'name' => 'rules_seo[rules_active]',
            'values' => array(

                array(
                    'value' => 0,
                    'label' => Mage::helper('catalog')->__('Inactive'),
                ),

                array(
                    'value' => 1,
                    'label' => Mage::helper('catalog')->__('Active'),
                ),
            ),
            'value' => 1,
        ));


        $fieldset->addField('rules_title', 'textarea',
            array(
                'name' => 'rules_seo[rules_title]',
                'label' => Mage::helper('catalog')->__('Title rules'),
                'class' => 'textarea title-rules',
                'required' => false,
            )
        );

        $fieldset->addField('rules_keywords', 'textarea',
            array(
                'name' => 'rules_seo[rules_keywords]',
                'label' => Mage::helper('catalog')->__('Title keywords'),
                'class' => 'textarea title-rules',
                'required' => false,
            )
        );

        $fieldset->addField('rules_description', 'textarea',
            array(
                'name' => 'rules_seo[rules_description]',
                'label' => Mage::helper('catalog')->__('Title description'),
                'class' => 'textarea title-rules',
                'required' => false,
            )
        );

        $fieldset->addField('rules_popular_options', 'textarea',
            array(
                'name' => 'rules_seo[rules_popular_options]',
                'label' => Mage::helper('catalog')->__('Most popular options'),
                'class' => 'textarea title-rules',
                'required' => false,
            )
        );

        $values = $this->getCategory()->getRulesData();
        if (isset($values)) {
            $form->addValues($values);
        }

        $this->setForm($form);

        return parent::_prepareLayout();
    }
}