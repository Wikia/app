/* global define */
define('wikia.articleNavUserTools', [
	'wikia.nirvana', 'wikia.tracker', 'wikia.window', 'wikia.userToolsHelper', 'wikia.dropdownNavigation', 'jquery', 'wikia.toolsCustomization'
], function (nirvana, tracker, win, userToolsHelper, DropdownNavigation, $, TC) {
	'use strict';
	var dropdownInstance;

	/**
	 * Initialize user tools
	 */
	function init() {
		var userToolsPromiseAfterChanges,
			initialUserTools = $('#articleNavSettings').data('usertools');
			loadDropdown(initialUserTools);

		$('body').on('userToolsItemAdded', function () {
			userToolsPromiseAfterChanges = getDropdownData();

			$.when(userToolsPromiseAfterChanges).done(function (userToolsData) {
				var userToolsItems = userToolsData.data;
				loadDropdown(userToolsItems);
			});
		});
	}

	/**
	 * Create dropdown, add tracking to it and enable customization
	 * @param {Object} userToolsItems - data returned by controller based on which dropdown is built
	 */
	function loadDropdown(userToolsItems) {
		var filteredItems = userToolsHelper.extractUserToolsItems(userToolsItems);

		createDropdown(filteredItems);
		trackUserTools();
		enableCustomizeModal();
	}

	/**
	 * Enable customization in user tools dropdown
	 */
	function enableCustomizeModal() {
		$('#userToolsDropdown').find('.tools-customize').on('click', function () {
			new TC.ToolsCustomization(this).show();
			return false;
		});
	}

	/**
	 * Get items for user tools from controller
	 * @returns {Object} promise
	 */
	function getDropdownData() {
		return nirvana.sendRequest({
			controller: 'ArticleNavigation',
			method: 'getUserTools',
			format: 'json',
			type: 'GET',
			data: {
				'title': win.wgTitle
			}
		});
	}

	/**
	 * Create dropdown with given items
	 * @param {Object} items which should be added to dropdown
	 */
	function createDropdown(items) {
		var $userToolsDropdown = $('#userToolsDropdown');
		if ($userToolsDropdown.length > 0) {
			$userToolsDropdown.remove();
		}

		dropdownInstance = new DropdownNavigation({
			id: 'userToolsDropdown',
			sections: items,
			trigger: 'articleNavSettings'
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
