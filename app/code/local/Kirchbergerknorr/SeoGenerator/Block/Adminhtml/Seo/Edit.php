<?php

class Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Seo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_seo';
        $this->_blockGroup = 'seogenerator';

        parent::__construct();

        $this->_updateButton('save', 'label', $this->__('Save Rule'));
        $this->_updateButton('delete', 'label', $this->__('Delete Rule'));

    }

    public function getHeaderText()
    {
        return $this->__("Edit Rule");
    }
}
