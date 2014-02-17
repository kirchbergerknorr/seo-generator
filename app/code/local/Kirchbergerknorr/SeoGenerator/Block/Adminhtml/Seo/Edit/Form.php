<?php

class Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Seo_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('seo_rules_form');
        $this->setTitle($this->__('Rule Information'));
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save'),
                'method' => 'post')
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
