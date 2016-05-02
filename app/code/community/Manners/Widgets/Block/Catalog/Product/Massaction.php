<?php

/**
 * @category    Manners
 * @package     Manners_Widgets
 * @copyright   Copyright (c) David Manners (http://davidmanners.de/)
 */

class Manners_Widgets_Block_Catalog_Product_Massaction extends Mage_Adminhtml_Block_Widget_Grid_Massaction
{
    /** @var string */
    private $sInternalName;

    /**
     * Set the field name for internal use
     *
     * @param string $sString
     * @return Manners_Widgets_Block_Catalog_Product_Massaction
     */
    public function setFormFieldNameInternal($sString)
    {
        $this->sInternalName = $sString;
        return $this;
    }

    /**
     * Get the form field name used internally
     *
     * @return string
     */
    public function getFormFieldNameInternal()
    {
        if ($this->sInternalName !== null) {
            return $this->sInternalName;
        }
        return parent::getFormFieldNameInternal();
    }

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
                ' . $iParentId . '.setElementValue(window.' . $this->getJsObjectName() . '.getCheckedValues());
                ' . $iParentId . '.setElementLabel(window.' . $this->getJsObjectName() . '.getCheckedValues());
                ' . $iParentId . '.close();
            })()';
    }

    /**
     * Get the javascript used for the grid massaction
     *
     * @return string
     */
    public function getJavaScript()
    {
        return " window.{$this->getJsObjectName()} = new varienGridMassaction('{$this->getHtmlId()}', "
        . "{$this->getGridJsObjectName()}, '{$this->getSelectedJson()}'"
        . ", '{$this->getFormFieldNameInternal()}', '{$this->getFormFieldName()}');"
        . "{$this->getJsObjectName()}.setItems({$this->getItemsJson()}); "
        . "{$this->getJsObjectName()}.setGridIds('{$this->getGridIdsJson()}');"
        . ($this->getUseAjax() ? "{$this->getJsObjectName()}.setUseAjax(true);" : '')
        . ($this->getUseSelectAll() ? "{$this->getJsObjectName()}.setUseSelectAll(true);" : '')
        . "{$this->getJsObjectName()}.errorText = '{$this->getErrorText()}';";
    }
}