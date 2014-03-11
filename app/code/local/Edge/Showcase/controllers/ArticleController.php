<?php
class Edge_Showcase_ArticleController extends Mage_Core_Controller_Front_Action
{
	public function viewAction()
	{
        $this->loadLayout()
             ->renderLayout();
	}
}