<?php

/**
 * @category    Manners
 * @package     Manners_Widgets
 * @copyright   Copyright (c) David Manners (http://davidmanners.de/)
 */

class Manners_Widgets_Block_Products extends Mage_Catalog_Block_Product implements Mage_Widget_Block_Interface
{
    private $oProductCollection;

    /**
     * Internal constructor
     */
    protected function _construct()
    {
        $this->oProductCollection = Mage::getModel('manners_widgets/collection_product');

        $this->setTemplate('manners/products.phtml');
        parent::_construct();
    }

    /**
     * Gets a collection of predefined products
     *
     * @return \Mage_Catalog_Model_Resource_Product_Collection
     * @throws \Mage_Core_Exception
     */
    public function getProductCollection()
    {
        $sProductIds = $this->getProductIds();

        return $this->oProductCollection->getFilteredByProductIds($sProductIds);
    }

    /**
     * Gets the price block to display with the selected products from
     * the collection.
     *
     * Overwrites \Mage_Catalog_Block_Product::getPriceHtml in order
     * to be able to build the price on no catalog pages.
     *
     * @param \Mage_Catalog_Model_Product $oProduct
     *
     * @return string
     */
    public function getPriceHtml(Mage_Catalog_Model_Product $oProduct)
    {
        $oProductBlock = $this->getLayout()->createBlock('catalog/product_price');
        echo $oProductBlock->getPriceHtml($oProduct, true);
    }
}