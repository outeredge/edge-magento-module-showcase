<?php

class Edge_Showcase_Block_Adminhtml_Showcase extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_showcase';
        $this->_blockGroup = 'showcase';
        $this->_headerText = Mage::helper('edge_showcase')->__('Showcase Management');
        $this->_addButtonLabel = Mage::helper('edge_showcase')->__('Add Article');
		parent::__construct();
    }
}
