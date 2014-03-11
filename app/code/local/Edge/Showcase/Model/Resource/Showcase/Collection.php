<?php

class Edge_Showcase_Model_Resource_Showcase_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	protected function _construct()
    {
        $this->_init('showcase/showcase');
    }
}