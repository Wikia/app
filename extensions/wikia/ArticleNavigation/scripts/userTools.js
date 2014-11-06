/* global define */
define('wikia.userTools', [
	'wikia.nirvana', 'wikia.tracker', 'wikia.window', 'wikia.dropdownNavigation', 'jquery'
], function (nirvana, tracker, win, DropdownNavigation, $) {
	'use strict';

	/**
	 * Initialize user tools
	 */
	function init() {
		var userToolsPromise = nirvana.sendRequest({
			controller: 'ArticleNavigation',
			method: 'getUserTools',
			format: 'json',
			type: 'GET'
		});

		$.when(userToolsPromise).done(function (toolbarData) {
			var toolbarItems = toolbarData.data,
				filteredItems = extractToolbarItems(toolbarItems);

			DropdownNavigation({
				id: 'userToolsDropdown',
				data: filteredItems,
				trigger: 'articleNavSettings'
			});

			trackUserTools();
		});
	}

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

	/**
	 * All logic related with tracking user tools
	 */
	function trackUserTools() {
		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			trackingMethod: 'both'
		});

		$('#userToolsDropdown').on('mousedown touchstart', 'a', function (e) {
			var label,
				el = e.target,
				name = $(el).data('name');

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			switch (name) {
			case 'customize':
			case 'follow':
			case 'history':
			case 'whatlinkshere':
				{
					label = name;
					break;
				}
			default:
				{
					label = 'custom';
					break;
				}
			}

			//add anon prefix for not logged in users
			if (!win.wgUserName) {
				label = 'anon-' + label;
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: 'toolbar',
					label: label
				});
			}
		});
	}

	return {
		init: init,
		extractToolbarItems: extractToolbarItems
	};
});
