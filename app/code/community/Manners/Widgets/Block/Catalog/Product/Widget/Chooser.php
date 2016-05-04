<?php

/**
 * @category    Manners
 * @package     Manners_Widgets
 * @copyright   Copyright (c) David Manners (http://davidmanners.de/)
 */

class Manners_Widgets_Block_Catalog_Product_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
{
    /**
     * Override the mass-action block that will be used
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setMassactionBlockName('manners_widgets/catalog_product_massaction');
    }

    /**
     * Add all the desired columns to the grid
     *
     * @return Manners_Widgets_Block_Catalog_Product_Widget_Chooser
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => Mage::helper('catalog')->__('ID'),
                'sortable' => true,
                'width' => '60px',
                'index' => 'entity_id',
            ]
        );
        $this->addColumn(
            'chooser_sku',
            [
                'header' => Mage::helper('catalog')->__('SKU'),
                'name' => 'chooser_sku',
                'width' => '80px',
                'index' => 'sku'
            ]
        );
        $this->addColumn(
            'chooser_name',
            [
                'header' => Mage::helper('catalog')->__('Product Name'),
                'name' => 'chooser_name',
                'index' => 'name'
            ]
        );
        return $this;
    }

    /**
     * Prepare the massaction
     *    - Block,
     *    - Item
     *
     * @return Manners_Widgets_Block_Catalog_Product_Widget_Chooser
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->setMassactionIdFilter('entity_id');

        /** @var Manners_Widgets_Block_Catalog_Product_Massaction $oMassActionBlock */
        $oMassActionBlock = $this->getMassactionBlock();
        $oMassActionBlock->setFormFieldName('products');
        $oMassActionBlock->setFormFieldNameInternal('element_value');
        $oMassActionBlock->setFormFieldTextInternal('element_label');
        $oMassActionBlock->setData('parent_id', $this->getId());

        /**
         * This is a dummy item that we do not actually need because of JavaScript processing
         */
        $oMassActionBlock->addItem(
            'add',
            [
                'label' => Mage::helper('catalog')->__('Add Products'),
                'url' => $this->getUrl('*/*/addProducts')
            ]
        );

        Mage::dispatchEvent(
            'manners_widgets_catalog_product_grid_prepare_massaction',
            ['block' => $this]
        );
        return $this;
    }

    /**
     * Prepare chooser element HTML
     *  - set the product names on the label
     *
     * @param Varien_Data_Form_Element_Abstract $oElement Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $oElement)
    {
        $oChooser = $this->getChooserBlock($oElement);

        if ($oElement->getValue()) {
            $aElementValues = explode(',', $oElement->getValue());
            $aLabels = [];
            foreach ($aElementValues as $iProductId) {
                $aLabels[] = Mage::getResourceSingleton('catalog/product')->getAttributeRawValue(
                    $iProductId,
                    'name',
                    Mage::app()->getStore()
                );
            }
            $oChooser->setLabel(implode(',', $aLabels));
        }

        $oElement->setData('after_element_html', $oChooser->toHtml());
        return $oElement;
    }

    /**
     * Get the chooser block to be used
     *
     * @param Varien_Data_Form_Element_Abstract $oElement
     * @return Mage_Core_Block_Abstract
     */
    private function getChooserBlock(Varien_Data_Form_Element_Abstract $oElement)
    {
        $iUniqId = Mage::helper('core')->uniqHash($oElement->getId());
        $sSourceUrl = $this->getUrl(
            '*/product_multiple_widget/chooser',
            [
                'uniq_id' => $iUniqId,
                'use_massaction' => true,
            ]
        );

        $oLayout = $this->getLayout();
        $oChooser = $oLayout->createBlock('widget/adminhtml_widget_chooser');
        $oChooser->setElement($oElement);
        $oChooser->setTranslationHelper($this->getTranslationHelper());
        $oChooser->setConfig($this->getConfig());
        $oChooser->setFieldsetId($this->getFieldsetId());
        $oChooser->setSourceUrl($sSourceUrl);
        $oChooser->setUniqId($iUniqId);
        return $oChooser;
    }
}
