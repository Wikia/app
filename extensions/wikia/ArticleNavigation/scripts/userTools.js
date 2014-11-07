/* global define */
define('wikia.userTools', [
	'wikia.nirvana', 'wikia.tracker', 'wikia.window', 'wikia.userToolsHelper', 'wikia.dropdownNavigation', 'jquery'
], function (nirvana, tracker, win, userToolsHelper, dropdownNavigation, $) {
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
				filteredItems = userToolsHelper.extractToolbarItems(toolbarItems);

			dropdownNavigation({
				id: 'userToolsDropdown',
				data: filteredItems,
				trigger: 'articleNavSettings'
			});

			trackUserTools();
		});
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
					label = name;
					break;
				default:
					label = 'custom';
					break;
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
		init: init
	};
});
