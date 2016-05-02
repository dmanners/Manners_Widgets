<?php

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

        $this->oProductCollection->addFieldToFilter('entity_id', array('in' => $aProductIds));

        $sCollectionOrder = new Zend_Db_Expr('FIELD(e.entity_id, ' . implode(',', $aProductIds).')');
        $this->oProductCollection->getSelect()->order($sCollectionOrder);

        return $this->oProductCollection;
    }

    private function addAttributesToCollection()
    {
        $this->oProductCollection->addAttributeToSelect(
            Mage::getSingleton('catalog/config')->getProductAttributes()
        );
        $this->oProductCollection->addMinimalPrice();
        $this->oProductCollection->addFinalPrice();
        $this->oProductCollection->addTaxPercents();

        return $this;
    }
}