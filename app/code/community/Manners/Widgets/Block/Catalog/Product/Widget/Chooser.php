<?php
/**
 * Manners_Widgets_Block_Catalog_Product_Widget_Chooser
 *
 * @author      david.manners
 * @category    Manners
 * @package     Manners_Widgets
 */
class Manners_Widgets_Block_Catalog_Product_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser {
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
	 *
	 * @return $this|Mage_Adminhtml_Block_Widget_Grid
	 */
	protected function _prepareMassaction() {
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('product');

		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('catalog')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('catalog')->__('Are you sure?')
		));

		$statuses = Mage::getSingleton('catalog/product_status')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('catalog')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'visibility' => array(
					'name' => 'status',
					'type' => 'select',
					'class' => 'required-entry',
					'label' => Mage::helper('catalog')->__('Status'),
					'values' => $statuses
				)
			)
		));

		if (Mage::getSingleton('admin/session')->isAllowed('catalog/update_attributes')){
			$this->getMassactionBlock()->addItem('attributes', array(
				'label' => Mage::helper('catalog')->__('Update Attributes'),
				'url'   => $this->getUrl('*/catalog_product_action_attribute/edit', array('_current'=>true))
			));
		}

		Mage::dispatchEvent('adminhtml_catalog_product_grid_prepare_massaction', array('block' => $this));
		return $this;
	}
}