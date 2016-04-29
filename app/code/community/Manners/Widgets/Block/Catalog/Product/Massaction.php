<?php
class Manners_Widgets_Block_Catalog_Product_Massaction extends Mage_Adminhtml_Block_Widget_Grid_Massaction{
    public function getApplyButtonHtml()
    {
        return $this->getButtonHtml(
            $this->__('Submit'),
            $this->getButtonJs()
        );
    }

    /**
     *             'var optionValue = "1,2,3,4";'
    . 'var optionLabel = "Product 1, Product 2,Product 3,Product 4";'
    . $iParentId.'.setElementValue(optionValue);'
    . $iParentId.'.setElementLabel(optionLabel);'
    . $iParentId.'.close()'
     * @return string
     */
    private function getButtonJs()
    {
        return '
            (function(){
                var sOptionValue = \'1,2,3\';
                var sOptionLabel = \'Test\';
                ' . $this->getData('parent_id').'.setElementValue(sOptionValue);
                ' . $this->getData('parent_id').'.setElementLabel(sOptionLabel);
                '. $this->getData('parent_id').'.close();
            })()';
    }
}