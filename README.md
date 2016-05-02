Manners_Widgets
===============

Magento Widget extension add some useful features to the Magento_Widget module.

Features
--------

* Multiple selection for products,

How it works
------------

*Products*

The product part of the system is based around the widget of type `manners_widgets/products`.
This widget is defined in the xml file `app/code/community/Manners/Widgets/etc/widget.xml`.
The widget comes with a chooser with the helper type `manners_widgets/catalog_product_widget_chooser`.

The chooser is based from the Magento standard chooser `Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser` but to make it work with mass actions the following has been changed:

* define new massaction block in `_construct`,
* add custom columns in `_prepareColumns`,
* add massaction items in `_prepareMassaction`,
* update chooser to use custom url in `prepareElementHtml`,

The chooser will end up using the controller `app/code/community/Manners/Widgets/controllers/Adminhtml/Product/Multiple/WidgetController.php`.
This controller is again the same as the standard `Mage_Adminhtml_Catalog_Product_WidgetController` apart from it uses `manners_widgets/catalog_product_widget_chooser` to build the grid.

The class `app/code/community/Manners/Widgets/Block/Catalog/Product/Massaction.php` is used to extend the JavaScript for row and button selection.
This will make sure that the `varienGridMassaction` is updated correctly and the selection is taken into account.

There is also an extension of the standard JavaScript under `js/manners/adminhtml/widgets.js` for the following:

* add new parameter,
* extend `varienGridMassaction.onGridRowClick` to set new parameter with the text value no id value of the row,

ToDo
----

* [Multiple selection for categories](https://github.com/dmanners/Manners_Widgets/issues/9),
* [Second load of selection before save](https://github.com/dmanners/Manners_Widgets/issues/8),