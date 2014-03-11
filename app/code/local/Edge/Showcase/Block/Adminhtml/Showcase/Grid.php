<?php

class Edge_Showcase_Block_Adminhtml_Showcase_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('showcase_grid');
        $this->setDefaultSort('date');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('showcase/showcase')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('edge_showcase')->__('ID'),
            'width'     => '50',
            'index'     => 'id'
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('edge_showcase')->__('Title'),
            'index'     => 'title'
        ));

        $this->addColumn('date', array(
            'header'    => Mage::helper('edge_showcase')->__('Date'),
            'index'     => 'date',
            'width'     => '50',
            'type'      => 'datetime',
            'format'    => 'd MMM Y'
        ));

//        $this->addColumn('status', array(
//            'header' => Mage::helper('edge_showcase')->__('Enabled'),
//            'align' => 'right',
//            'width' => '80px',
//            'index' => 'status',
//            'type' => 'options',
//            'options' => array(
//                1 => 'Yes',
//                0 => 'No'
//            )
//        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}