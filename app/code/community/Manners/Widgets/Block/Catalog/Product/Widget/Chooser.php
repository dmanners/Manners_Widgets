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
	 * Prepare chooser element HTML,
	 *  - get the config variable 'use_massaction' from the xml,
	 *    - if it is true then use this when creating the url
	 *
	 * @param Varien_Data_Form_Element_Abstract $oElement Form Element
	 * @return Varien_Data_Form_Element_Abstract
	 */
	public function prepareElementHtml(Varien_Data_Form_Element_Abstract $oElement) {
		$bUseMassAction = false;
		if($this->getConfig('use_massaction') == true) {
			$bUseMassAction = true;
		}
		$iUniqueId = Mage::helper('core')->uniqHash($oElement->getId());
		$aUrlVariables = array(
			'uniq_id'			=> $iUniqueId,
			'use_massaction'	=> $bUseMassAction
		);
		$sSourceUrl = $this->getUrl('*/catalog_product_widget/chooser', $aUrlVariables);

		$oChooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
			->setElement($oElement)
			->setTranslationHelper($this->getTranslationHelper())
			->setConfig($this->getConfig())
			->setFieldsetId($this->getFieldsetId())
			->setSourceUrl($sSourceUrl)
			->setUniqId($iUniqueId);

		if ($oElement->getValue()) {
			$aValue = explode('/', $oElement->getValue());
			$iProductId = FALSE;
			if (isset($aValue[0]) && isset($aValue[1]) && $aValue[0] == 'product') {
				$iProductId = $aValue[1];
			}
			$iCategoryId = isset($aValue[2]) ? $aValue[2] : false;
			$sLabel = '';
			if ($iCategoryId) {
				$sLabel = Mage::getResourceSingleton('catalog/category')
					->getAttributeRawValue($iCategoryId, 'name', Mage::app()->getStore()) . '/';
			}
			if ($iProductId) {
				$sLabel .= Mage::getResourceSingleton('catalog/product')
					->getAttributeRawValue($iProductId, 'name', Mage::app()->getStore());
			}
			$oChooser->setLabel($sLabel);
		}

		$oElement->setData('after_element_html', $oChooser->toHtml());
		return $oElement;
	}
}