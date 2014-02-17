<?php

class  Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Seo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('seo_rules_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('SEO Rule'));
    }

    protected function _beforeToHtml()
    {

        $this->addTab('main_section', array(
            'label' => $this->__('Rule Edit/View'),
            'title' => $this->__('Rule Edit/View'),
            'content' => $this->getLayout()->createBlock('seogenerator/adminhtml_seo_edit_tab_main')->toHtml(),
            'active' => true

        ));

        $this->addTab('preview_section', array(
            'label' => $this->__('Preview Rules'),
            'title' => $this->__('Preview Rules'),
            'content' => $this->getLayout()->createBlock('Mage_Core_Block_Template', 'editmetatag', array('template' => 'seogenerator/form/preview.phtml'))->toHtml(),

        ));

        return parent::_beforeToHtml();
    }
}