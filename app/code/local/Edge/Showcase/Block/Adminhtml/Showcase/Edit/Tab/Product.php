<?php

class Edge_Showcase_Block_Adminhtml_Showcase_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('products');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

	protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*');

		if (!$this->getRequest()->getParam('isAjax')){
			$collection->addFieldToFilter('entity_id', array('in' => $this->_getProducts()));
		}

		$this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
		$this->addColumn('products', array(
			'header_css_class' => 'a-center',
			'type'       => 'checkbox',
			'name'       => 'products',
			'values'     => $this->_getProducts(),
			'align'      => 'center',
			'index'      => 'entity_id',
            'field_name' => 'products[]'
		));

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('edge_showcase')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('edge_showcase')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('sku', array(
            'header'    => Mage::helper('edge_showcase')->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ));

		$this->addColumn('type', array(
            'header'    => Mage::helper('edge_showcase')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name', array(
            'header'    => Mage::helper('edge_showcase')->__('Attrib. Set Name'),
            'width'     => 130,
            'index'     => 'attribute_set_id',
            'type'      => 'options',
            'options'   => $sets,
        ));

		$this->addColumn('price', array(
            'header'        => Mage::helper('edge_showcase')->__('Price'),
            'type'          => 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'         => 'price'
        ));

        $this->addColumn('visibility', array(
            'header'    => Mage::helper('edge_showcase')->__('Visibility'),
            'width'     => 90,
            'index'     => 'visibility',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('edge_showcase')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        return parent::_prepareColumns();
    }

	protected function _getProducts()
    {
		$products = $this->getRequest()->getPost('products');
        if (is_null($products)) {
            return Mage::registry('showcase')->getProducts();
        }
        return $products;
    }

	public function getGridUrl()
    {
        return $this->getUrl('*/*/productGrid', array('_current' => true));
    }

    public function getTabLabel()
    {
        return Mage::helper('edge_showcase')->__('Products');
    }

    public function getTabTitle()
    {
        return Mage::helper('edge_showcase')->__('Products');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}