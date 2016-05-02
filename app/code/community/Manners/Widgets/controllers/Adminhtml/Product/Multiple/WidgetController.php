<?php

/**
 * @category    Manners
 * @package     Manners_Widgets
 * @copyright   Copyright (c) David Manners (http://davidmanners.de/)
 */

class Manners_Widgets_Adminhtml_Product_Multiple_WidgetController extends Mage_Adminhtml_Controller_Action
{
    /**
     * This function is the same as Mage_Adminhtml_Catalog_Product_WidgetController::chooserAction
     * but with an update product grid block
     */
    public function chooserAction()
    {
        $oRequest = $this->getRequest();
        $iUniqId = $oRequest->getParam('uniq_id');
        $bMassAction = $oRequest->getParam('use_massaction', false);
        $iProductTypeId = $oRequest->getParam('product_type_id', null);

        $oLayout = $this->getLayout();
        $oProductsGrid = $oLayout->createBlock(
            'manners_widgets/catalog_product_widget_chooser',
            '',
            [
                'id' => $iUniqId,
                'use_massaction' => $bMassAction,
                'product_type_id' => $iProductTypeId,
                'category_id' => $this->getRequest()->getParam('category_id')
            ]
        );

        $sChooserHtml = $oProductsGrid->toHtml();

        if (!$oRequest->getParam('products_grid')) {
            $oCategoriesTree = $oLayout->createBlock(
                'adminhtml/catalog_category_widget_chooser',
                '',
                [
                    'id' => $iUniqId . 'Tree',
                    'node_click_listener' => $oProductsGrid->getCategoryClickListenerJs(),
                    'with_empty_node' => true
                ]
            );

            $oChooserContainer = $oLayout->createBlock('adminhtml/catalog_product_widget_chooser_container');
            $oChooserContainer->setTreeHtml($oCategoriesTree->toHtml());
            $oChooserContainer->setGridHtml($sChooserHtml);
            $sChooserHtml = $oChooserContainer->toHtml();
        }

        $this->getResponse()->setBody($sChooserHtml);
    }

    /**
     * Check is allowed access to action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/widget_instance');
    }
}
