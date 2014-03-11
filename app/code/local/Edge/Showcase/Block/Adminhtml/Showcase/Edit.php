<?php

class Edge_Showcase_Block_Adminhtml_Showcase_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
		parent::__construct();

        $this->_objectId = 'id';
		$this->_blockGroup = 'showcase';
        $this->_controller = 'adminhtml_showcase';

		$this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('edge_showcase')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

		$this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

	protected function _prepareLayout()
    {
		parent::_prepareLayout();
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()){
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		}
    }

    public function getHeaderText()
    {
		return Mage::helper('edge_showcase')->__('Edit Article');
    }
}
