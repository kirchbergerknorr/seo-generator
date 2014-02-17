<?php
class Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Seo_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('seo_rules_tab_main');
        $this->setTitle($this->__('Rule View'));
    }

    public function _prepareLayout()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset',
            array('legend' => Mage::helper('seogenerator')->__('Meta Tags Templates'))
        );

        $values =  Mage::registry('seogenerator_rules')->getData();

        if (isset($values['rules_id'])) {
             $fieldset->addField('rules_id', 'hidden', array(
                 'name' => 'rules_id',
             ));
         }

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

        if (isset($values)) {
            $form->addValues($values);
        }

        $this->setForm($form);
        return parent::_prepareLayout();
    }
}