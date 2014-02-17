<?php

class Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Seo_Edit_Tab_Preview extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('seo_rules_tab_preview');
        $this->setTitle($this->__('Preview Rules'));
        $this->setUseAjax(true);
    }

    public function _prepareLayout()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset',
            array('legend' => Mage::helper('seogenerator')->__('Preview Rules'))
        );

        $values = Mage::registry('seogenerator_rules')->getData();

        $fieldset->addField('rules_title', 'multiline',
            array(
                'name' => 'rules_seo[rules_title]',
                'label' => Mage::helper('catalog')->__('Title rules'),
                'class' => 'textarea title-rules',
                'required' => false,
            )
        );

        $this->setForm($form);
        return parent::_prepareLayout();
    }
}