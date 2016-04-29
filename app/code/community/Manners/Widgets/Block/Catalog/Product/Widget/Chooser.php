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
}
