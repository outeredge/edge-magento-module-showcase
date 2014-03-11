<?php

class Edge_Showcase_Block_List extends Mage_Core_Block_Template
{
    private $date = null;

    protected function _construct()
    {
        parent::_construct();

        $this->date = $this->getRequest()->getParam('date');
    }

    public function _prepareLayout()
    {
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbs->addCrumb('home', array(
                'label' => Mage::helper('edge_showcase')->__('Home'),
                'title' => Mage::helper('edge_showcase')->__('Go to Home Page'),
                'link'  => Mage::getBaseUrl()
            ));

            if ($this->date) {
                $breadcrumbs->addCrumb('showcase', array(
                    'label' => Mage::helper('edge_showcase')->__('Showcase'),
                    'title' => Mage::helper('edge_showcase')->__('Showcase'),
                    'link'  => Mage::getBaseUrl() . 'showcase'
                ));
                $breadcrumbs->addCrumb('date', array(
                    'label' => Mage::helper('edge_showcase')->__($this->getCurrentDateRage()),
                    'title' => Mage::helper('edge_showcase')->__($this->getCurrentDateRage())
                ));
            }
            else {
                $breadcrumbs->addCrumb('showcase', array(
                    'label' => Mage::helper('edge_showcase')->__('Showcase'),
                    'title' => Mage::helper('edge_showcase')->__('Showcase')
                ));
            }
        }
        return parent::_prepareLayout();
    }

    public function getCurrentDateRage() {
        if ($this->date) {
            return date('F Y', strtotime($this->date));
        }

        else return 'Showing Recent Articles';
    }

    public function getImage($file)
    {
        return Mage::getBaseUrl('media') . $file;
    }

    /**
     * Get collection of articles
     * @param boolean $byDate Set true to fitle by date URL param, false to force retrieval of all articles.
     * @param integer $limit Set limit of results. Default is 6 for recent article page
     * @return collection
     */
    public function getArticles($byDate = true, $limit = 6)
    {
        $collection = Mage::getModel('showcase/showcase')
            ->getCollection()
            ->setOrder('date', 'DESC');

        if($byDate && $this->date) {
            $collection->addFieldToFilter('date', array('from' => $this->date . '-01'))
                       ->addFieldToFilter('date', array('to' => $this->date . date('t',  strtotime($this->date))));
        }
        else {
            $collection->setPageSize($limit);
        }

        return $collection;
    }

    /**
     *  Gets a list of Years/Months for date select drop down
     * @return array
     */
    public function getDateOptions()
    {
        $articles = $this->getArticles(false, false);
        $dates = array();

        if($this->date) {
            $dates = array(
                '/showcase' => 'Recent Articles'
            );
        }

        foreach($articles as $article) {
            $date = date('F Y',strtotime($article->getDate()));
            if (!in_array($date, $dates)) {
                $dates['/showcase/' . strtolower(date('Y/F',strtotime($article->getDate())))] = $date;
            }
        }

        return $dates;
    }
}