<?php foreach ($widgets as $widgetName => $widgetData) {
	$widgetForm = $widgetData['form'];
	$widgetHtmlMenuItem = $widgetData['editor_menu_item_html'];
	$widgetHtmlListItem = $widgetData['editor_list_item_html'];
	$widgetHtmlTemplate = $widgetData['html'];
	$widgetAttributes = $widgetData['attributes'];
	$widgetRequiredAttributes = $widgetData['required_attributes'];
	$widgetAttributeCaptions = $widgetData['attribute_captions'];
	$widgetLogic = $widgetData['logic'];
?>
PageLayoutBuilder.Library['<?php echo $widgetName; ?>'] = {
	editorHtml: <?php echo $widgetForm; ?>,
	menuItemHtml: <?php echo $widgetHtmlMenuItem; ?>,
	listItemHtml: <?php echo $widgetHtmlListItem; ?>,
	templateHtml: <?php echo $widgetHtmlTemplate; ?>,
	attributes: <?php echo $widgetAttributes; ?>,
	attributeCaptions: <?php echo $widgetAttributeCaptions; ?>,
	requiredAttributes: <?php echo $widgetRequiredAttributes; ?><?php echo empty($widgetLogic)?"":","?>
	<?php echo $widgetLogic; ?>
};
<?php } ?>
PageLayoutBuilder.Data = <?php echo $data; ?>;
PageLayoutBuilder.Lang = <?php echo $messages; ?>;
