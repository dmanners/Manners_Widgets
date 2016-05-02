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
        return sprintf(
            '(function(){
                %1$s.setElementValue(window.%2$s.getCheckedValues());
                %1$s.setElementLabel(window.%2$s.getTextValue());
                %1$s.close();
            })()',
            $this->getData('parent_id'),
            $this->getJsObjectName()
        );
    }

    /**
     * Get the javascript used for the grid massaction
     *
     * @return string
     */
    public function getJavaScript()
    {
        $sJavaScript = sprintf(
            'window.%1$s = new varienGridMassaction(
                "%2$s",
                %3$s,
                "%4$s",
                "%5$s",
                "%6$s");
            %1$s.setItems(%7$s);
            %1$s.setGridIds("%8$s");
            %1$s.errorText = "%9$s"; ',
            $this->getJsObjectName(),
            $this->getHtmlId(),
            $this->getGridJsObjectName(),
            $this->getSelectedJson(),
            $this->getFormFieldNameInternal(),
            $this->getFormFieldName(),
            $this->getItemsJson(),
            $this->getGridIdsJson(),
            $this->getErrorText()
        );
        if ($this->getUseAjax()) {
            $sJavaScript .= sprintf(
                '%1$s.setUseAjax(true);',
                $this->getJsObjectName()
            );
        }
        if ($this->getUseSelectAll()) {
            $sJavaScript .= sprintf(
                '%1$s.setUseSelectAll(true);',
                $this->getJsObjectName()
            );
        }
        return $sJavaScript;
    }
}
