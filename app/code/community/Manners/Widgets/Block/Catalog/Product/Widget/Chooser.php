<?php
class Manners_Widgets_Block_Catalog_Product_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
{
	/**
	 * Override the mass-action block that will be used
	 */
	protected function _construct(){
		parent::_construct();
		$this->setMassactionBlockName('manners_widgets/catalog_product_massaction');
	}

	/**
	 *
	 * @return Mage_Adminhtml_Block_Widget_Grid|void
	 */
	protected function _prepareColumns() {
		$this->addColumn('entity_id', array(
			'header'    => Mage::helper('catalog')->__('ID'),
			'sortable'  => true,
			'width'     => '60px',
			'index'     => 'entity_id'
		));
		$this->addColumn('chooser_sku', array(
			'header'    => Mage::helper('catalog')->__('SKU'),
			'name'      => 'chooser_sku',
			'width'     => '80px',
			'index'     => 'sku'
		));
		$this->addColumn('chooser_name', array(
			'header'    => Mage::helper('catalog')->__('Product Name'),
			'name'      => 'chooser_name',
			'index'     => 'name'
		));
	}

	/**
	 * Prepare the massaction
	 * 	- Block,
	 * 	- Item
	 *
	 * @return $this|Mage_Adminhtml_Block_Widget_Grid
	 */
	protected function _prepareMassaction() {
		$this->setMassactionIdField('entity_id');
		$this->setMassactionIdFilter('entity_id');
		$this->getMassactionBlock()->setFormFieldName('product');

		$this->getMassactionBlock()->setData('parent_id', $this->getId());
		$this->getMassactionBlock()->addItem('add', array(
			'label'=> Mage::helper('catalog')->__('Add Products'),
			'url'  => $this->getUrl('*/*/addProducts')
		));

		Mage::dispatchEvent('manners_widgets_catalog_product_grid_prepare_massaction', array('block' => $this));
		return $this;
	}

	/**
	 * Prepare chooser element HTML
	 *
	 * @param Varien_Data_Form_Element_Abstract $element Form Element
	 * @return Varien_Data_Form_Element_Abstract
	 */
	public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
	{
		$uniqId = Mage::helper('core')->uniqHash($element->getId());
		$sourceUrl = $this->getUrl('*/catalog_product_widget/chooser', array(
			'uniq_id' => $uniqId,
			'use_massaction' => true,
		));

		$chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
			->setElement($element)
			->setTranslationHelper($this->getTranslationHelper())
			->setConfig($this->getConfig())
			->setFieldsetId($this->getFieldsetId())
			->setSourceUrl($sourceUrl)
			->setUniqId($uniqId);

		if ($element->getValue()) {
			$value = explode(',', $element->getValue());
			$aLabels = [];
			foreach ($value as $iProductId) {
				$aLabels[] = Mage::getResourceSingleton('catalog/product')->getAttributeRawValue($iProductId, 'name', Mage::app()->getStore());
			}
			$chooser->setLabel(implode(',', $aLabels));
		}

		$element->setData('after_element_html', $chooser->toHtml());
		return $element;
	}
}
