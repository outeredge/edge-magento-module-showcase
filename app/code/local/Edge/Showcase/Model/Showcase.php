<?php

class Edge_Showcase_Model_Showcase extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('showcase/showcase');
    }

    public function getProducts()
	{
		$products = $this->getProductsJson();
		if ($products){
			return json_decode($products, true);
		}
		return array();
	}

	public function getProductsJson()
	{
		$products = $this->getData('products');
		if ($products){
			return $products;
		}
        return false;
	}
}