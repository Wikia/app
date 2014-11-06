/* global define */
define('wikia.articleNavigationHelper', function() {
	'use strict';

	function extractToolbarItems(toolbarData) {
		var items = [],
			toolbarItemsCount = toolbarData.length,
			currentItem, i;

		for (i=0; i<toolbarItemsCount; i++) {
			currentItem = toolbarData[i];
			if (currentItem.type !== 'disabled' && currentItem.href && currentItem.caption) {
				items.push({
					'title': currentItem.caption,
					'href': currentItem.href
				});
			}
		}

		return items;
	}

	return {
		extractToolbarItems: extractToolbarItems
	};
});
