<?php
class Edge_Showcase_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        $this->loadLayout()
             ->renderLayout();
	}
}