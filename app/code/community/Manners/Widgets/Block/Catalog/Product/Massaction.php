<?php
class Manners_Widgets_Block_Catalog_Product_Massaction extends Mage_Adminhtml_Block_Widget_Grid_Massaction
{
    /**
     * Set-up the button
     *
     * @return string
     */
    public function getApplyButtonHtml()
    {
        return $this->getButtonHtml(
            $this->__('Submit'),
            $this->getButtonJs()
        );
    }

    /**
     * Get the onClick function
     *
     * @return string
     */
    private function getButtonJs()
    {
        $iParentId = $this->getData('parent_id');
        return '
            (function(){
                var aOptionValue = [];
                var aOptionLabel = [];
                $$(\'#' . $iParentId . ' div.grid input[type=checkbox]\').each(function(item) {
                    if(item.checked === true) {
                        aOptionValue.push(item.value);
                        aOptionLabel.push($(item).up().siblings().last().innerHTML.trim());
                    }
                });
                ' . $iParentId . '.setElementValue(aOptionValue.join(\',\'));
                ' . $iParentId . '.setElementLabel(aOptionLabel.join(\',\'));
                '. $iParentId . '.close();
            })()';
    }
}