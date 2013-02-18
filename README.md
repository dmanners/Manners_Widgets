Manners_Widgets
===============

Magento Widget extension add some useful features to the Magento_Widget module

Features of the Manners_Widgets Extension
------------------
* Multiple select for products and categories,

Development information
------------------
* Create app\etc\modules\Manners_widgets.xml
	* Set codePool as community
	* Set depends on
		* Mage_Adminhtml
		* Mage_Widgets
* Create app\code\community\Manners\Widgets\etc\config.xml
	* Define blocks and helpers to use "manners_widgets"
* Create app\code\community\Manners\Widgets\etc\widget.xml
	* Define widget "manners_widgets_products"
		* Set type and module
		* Give and name and description,
		* Set the parameter prodct_ids with a helper block "manners_widgets/catalog_product_widget_chooser"
		* Set the use_massaction as true
* Create app\code\community\Manners\Widgets\Block\Catalog\Product\Widget\Chooser.php
	* Extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser
	* Update the function prepareElementHtml
		* Check for config value "use_massaction" and update the source url of the chooser block
* Create app\code\community\Manners\Widgets\Helper\Data.php
	* Extends Mage_Core_Helper_Abstract