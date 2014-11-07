/* global define */
define('wikia.userToolsHelper', [], function() {
	'use strict';

	/**
	 * Extract data needed for DropdownNavigation module from passed object
	 * @param {Object} toolbarData - object which contains all data related with user tools
	 * @returns {Array} - array with items which are acceptable by DropdownNavigation module
	 */
	function extractToolbarItems(toolbarData) {
		var items = [],
			toolbarItemsCount = toolbarData.length,
			currentItem, i;

		for (i = 0; i < toolbarItemsCount; i++) {
			currentItem = toolbarData[i];
			if (currentItem.type !== 'disabled' && currentItem.href && currentItem.caption) {
				items.push({
					title: currentItem.caption,
					href: currentItem.href,
					dataAttr: [{
						key: 'name',
						value: currentItem['tracker-name']
					}]
				});
			}
		}

		return items;
	}

	return {
		extractToolbarItems: extractToolbarItems
	};

});
