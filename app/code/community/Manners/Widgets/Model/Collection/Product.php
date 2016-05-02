<?php

/**
 * @category    Manners
 * @package     Manners_Widgets
 * @copyright   Copyright (c) David Manners (http://davidmanners.de/)
 */

class Manners_Widgets_Model_Collection_Product
{
    private $oProductCollection;

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->oProductCollection = Mage::getModel('catalog/product')->getCollection();
    }

    /**
     * Returns a Product Collection filtered by passed product ids.
     *
     * @param string $sProductIds
     *
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getFilteredByProductIds($sProductIds)
    {
        $aProductIds = array_map('intval', explode(',', $sProductIds));

        $this->addAttributesToCollection();
        $this->addFiltersToCollection($aProductIds);
        $this->addSortingToCollection($aProductIds);

        return $this->oProductCollection;
    }

    /**
     * Add basic product attributes to collection
     *
     * @return $this
     */
    private function addAttributesToCollection()
    {
        $this->oProductCollection->addAttributeToSelect(
            Mage::getSingleton('catalog/config')->getProductAttributes()
        );
        $this->oProductCollection->addMinimalPrice();
        $this->oProductCollection->addFinalPrice();
        $this->oProductCollection->addTaxPercents();
        $this->oProductCollection->addWebsiteNamesToResult();
        $this->oProductCollection->addTierPriceData();

        return $this;
    }

    /**
     * Add various filters to collection
     *
     * @param $aProductIds
     *
     * @return $this
     */
    private function addFiltersToCollection($aProductIds)
    {
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($this->oProductCollection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->oProductCollection);
        $this->oProductCollection->addIdFilter($aProductIds);
        $this->oProductCollection->addStoreFilter();
        $this->oProductCollection->addWebsiteFilter();

        return $this;
    }

    /**
     * Add sorting through entity_id to collection
     *
     * @param $aProductIds
     *
     * @return $this
     */
    private function addSortingToCollection($aProductIds)
    {
        $sCollectionOrder = new Zend_Db_Expr('FIELD(entity_id, ' . implode(',', $aProductIds) . ')');
        $this->oProductCollection->getSelect()->order($sCollectionOrder);

        return $this;
    }
}