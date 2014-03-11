<?php

class Edge_Showcase_Block_View extends Mage_Catalog_Block_Product_Abstract
{
    static $article = null;

    public function __construct()
    {
		parent::__construct();
        $this->article = Mage::getModel('showcase/showcase')->load($this->getRequest()->getParam('id'));
    }

    public function _prepareLayout()
    {
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbs->addCrumb('home', array(
                'label' => Mage::helper('edge_showcase')->__('Home'),
                'title' => Mage::helper('edge_showcase')->__('Go to Home Page'),
                'link'  => Mage::getBaseUrl()
            ));
            $breadcrumbs->addCrumb('showcase', array(
                'label' => Mage::helper('edge_showcase')->__('Showcase'),
                'title' => Mage::helper('edge_showcase')->__('View All Articles'),
                'link'  => '/showcase'
            ));
                $breadcrumbs->addCrumb('date', array(
                    'label' => Mage::helper('edge_showcase')->__(date('F Y', strtotime($this->article->getDate()))),
                    'title' => Mage::helper('edge_showcase')->__(date('F Y', strtotime($this->article->getDate()))),
                    'link'  => '/showcase/' . strtolower(date('Y/F', strtotime($this->article->getDate())))
                ));
            $breadcrumbs->addCrumb('article', array(
                'label' => Mage::helper('edge_showcase')->__($this->article->getTitle()),
                'title' => Mage::helper('edge_showcase')->__($this->article->getTitle())
            ));
        }
        return parent::_prepareLayout();
    }

    public function getArticle()
    {
        return $this->article;
    }

    public function getImage($file)
    {
        return Mage::getBaseUrl('media') . $file;
    }

    public function getProducts()
    {
        return Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToFilter('entity_id', array('in' => $this->article->getProducts()));
    }

    /**
     * Gets last posted article (based on date)
     * @return collection
     */
    public function getPreviousArticle()
    {
        $collection = Mage::getModel('showcase/showcase')
            ->getCollection()
            ->addFieldToFilter('date', array('to' => $this->article->getDate()))
            ->addFieldToFilter('id', array('neq' => $this->article->getId()))
            ->setOrder('date', 'DESC')
            ->getFirstitem();

        if($collection->getId()) {
            return $collection;
        }

        return null;
    }

    /**
     * Gets next posted article (based on date)
     * @return collection
     */
    public function getNextArticle()
    {
        $collection = Mage::getModel('showcase/showcase')
            ->getCollection()
            ->addFieldToFilter('date', array('from' => $this->article->getDate()))
            ->addFieldToFilter('id', array('neq' => $this->article->getId()))
            ->setOrder('date', 'ASC')
            ->getFirstitem();

        if($collection->getId()) {
            return $collection;
        }

        return null;
    }
}