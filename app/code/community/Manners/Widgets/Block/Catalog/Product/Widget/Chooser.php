<?php
class Manners_Widgets_Block_Catalog_Product_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
{
	/**
	 * Overrive the massaction block that will be used
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

//	/**
//	 * Checkbox Check JS Callback
//	 *
//	 * @return string
//	 */
//	public function getCheckboxCheckCallback()
//	{
//		return "function (grid, element) {
//                $(grid.containerId).fire('product:changed', {element: element});
//            }";
//	}

//	/**
//	 * Grid Row JS Callback
//	 *
//	 * @return string
//	 */
//	public function getRowClickCallback()
//	{
//		$chooserJsObject = $this->getId();
//		return '
//                    function (grid, event) {
//                        var trElement = Event.findElement(event, "tr");
//                        var productId = trElement.down("td").innerHTML;
//                        var productName = trElement.down("td").next().next().innerHTML;
//                        var optionLabel = productName;
//                        var optionValue = "product/" + productId.replace(/^\s+|\s+$/g,"");
//                        if (grid.categoryId) {
//                            optionValue += "/" + grid.categoryId;
//                        }
//                        if (grid.categoryName) {
//                            optionLabel = grid.categoryName + " / " + optionLabel;
//                        }
//                        '.$chooserJsObject.'.setElementValue(optionValue);
//                        '.$chooserJsObject.'.setElementLabel(optionLabel);
//                        '.$chooserJsObject.'.close();
//                    }
//                ';
//	}
}