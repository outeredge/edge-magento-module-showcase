<?php

class Edge_Showcase_Block_Adminhtml_Showcase_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('showcase');
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'=>Mage::helper('edge_showcase')->__('General Information'),
            'class' => 'fieldset-wide'
        ));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

        $fieldset->addField('title', 'text', array(
			'label'     => Mage::helper('edge_showcase')->__('Title'),
            'name'      => 'title'
        ));

        $fieldset->addField('description', 'textarea', array(
            'label' => Mage::helper('edge_showcase')->__('Description'),
            'name' => 'description'
        ));

        $fieldset->addField('date', 'date', array(
            'name' => 'date',
            'label' => Mage::helper('edge_showcase')->__('Article Date'),
            'image'  => Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'/adminhtml/default/default/images/grid-cal.gif',
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM),
        ));

        $fieldset->addField('thumbnail', 'image', array(
			'label'     => Mage::helper('edge_showcase')->__('Thumbnail Image - 280 x 280px'),
            'name'      => 'thumbnail',
            'url'       => 'showcase'
        ));

        $fieldset->addField('image', 'image', array(
			'label'     => Mage::helper('edge_showcase')->__('Main Image - 696 x 522px'),
            'name'      => 'image'
        ));

        $fieldset->addField('url_key', 'text', array(
			'label'     => Mage::helper('edge_showcase')->__('URL Key'),
            'name'      => 'url_key',
            'disabled'  => 'disabled'
        ));

		$form->setValues($model->getData());

        return parent::_prepareForm();
    }
}