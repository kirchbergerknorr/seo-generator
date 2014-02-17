<?php

class Kirchbergerknorr_SeoGenerator_Block_Adminhtml_Seo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('rules_id');
        $this->setDefaultSort('rules_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }


    protected function _prepareCollection()
    {
        $collection = Mage::getModel('seogenerator/rules')->getCollection()->joinCategory();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('rules_id',
            array(
                'header' => 'ID',
                'align' => 'right',
                'width' => '50px',
                'index' => 'rules_id',
            ));

        $this->addColumn('category_name',
            array(
                'header' => Mage::helper('catalog')->__('Category Name'),
                'align' => 'left',
                'index' => 'category_name',
            ));

        $this->addColumn('rules_title', array(
            'header' => Mage::helper('catalog')->__('Title'),
            'align' => 'left',
            'index' => 'rules_title',
        ));

        $this->addColumn('rules_description', array(
            'header' => Mage::helper('catalog')->__('Description'),
            'align' => 'left',
            'index' => 'rules_description',
        ));
        $this->addColumn('rules_keywords', array(
            'header' => Mage::helper('catalog')->__('Keywords'),
            'align' => 'left',
            'index' => 'rules_keywords',
        ));

        $this->addColumn('rules_popular_options', array(
            'header' => Mage::helper('catalog')->__('Popular Options'),
            'align' => 'left',
            'index' => 'rules_popular_options',
        ));

        $this->addColumn('rules_popular_options', array(
            'header' => Mage::helper('catalog')->__('Popular Options'),
            'align' => 'left',
            'index' => 'rules_popular_options',
        ));

        $this->addColumn('rules_active',
            array(
                'header' => Mage::helper('catalog')->__('Status'),
                'width' => '70px',
                'index' => 'rules_active',
                'type' => 'options',
                'options' => array('1' => Mage::helper('catalog')->__('Enabled'), '0' => Mage::helper('catalog')->__('Disabled')),
            ));

        return parent::_prepareColumns();
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('rules_id');
        $this->getMassactionBlock()->setFormFieldName('seo_rules_form');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('seogenerator')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('seogenerator')->__('Are you sure?')
        ));


        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}