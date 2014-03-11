<?php

class Edge_Showcase_Block_Adminhtml_Showcase_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function _construct()
    {
        parent::_construct();
        $this->setId('showcase_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('edge_showcase')->__('Showcase'));
    }

	protected function _beforeToHtml()
    {
        $this->addTab('showcase_general', array(
            'label'		=> Mage::helper('edge_showcase')->__('General'),
            'title'		=> Mage::helper('edge_showcase')->__('General'),
            'content'	=> $this->getLayout()->createBlock('showcase/adminhtml_showcase_edit_tab_general')->toHtml()
        ));

        $this->addTab('showcase_products', array(
            'label'		=> Mage::helper('edge_showcase')->__('Products'),
            'title'		=> Mage::helper('edge_showcase')->__('Products'),
            'content'	=> $this->getLayout()->createBlock('showcase/adminhtml_showcase_edit_tab_product', 'showcase_product_grid')->toHtml()
        ));

		return parent::_beforeToHtml();
    }
}