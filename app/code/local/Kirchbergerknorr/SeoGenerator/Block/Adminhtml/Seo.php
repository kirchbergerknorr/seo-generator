<?php
class Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Seo extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_seo';
        $this->_blockGroup = 'seogenerator';
        $this->_backButtonLabel = Mage::helper('catalog')->__('Back');
        $this->_addButtonLabel = Mage::helper('catalog')->__('Add Rule');
        $this->_headerText =Mage::helper('catalog')->__('Rules');

        parent::__construct();
    }
}