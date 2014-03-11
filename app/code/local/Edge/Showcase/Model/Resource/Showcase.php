<?php

class Edge_Showcase_Model_Resource_Showcase extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('showcase/showcase', 'id');
    }
}
