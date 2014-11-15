/* global define */
define('wikia.articleNavUserTools', [
	'wikia.nirvana', 'wikia.tracker', 'wikia.window', 'wikia.dropdownNavigation', 'jquery', 'wikia.toolsCustomization'
], function (nirvana, tracker, win, DropdownNavigation, $, TC) {
	'use strict';
	var dropdownInstance, entryPoint;

	/**
	 * Initialize user tools
	 */
	function init() {
		var userToolsPromiseAfterChanges,
			$articleNavSettings = $('#articleNavSettings'),
			initialUserTools = $articleNavSettings.data('usertools');

		entryPoint = $articleNavSettings.closest('li');
		loadDropdown(initialUserTools);

		$('body').on('userToolsItemAdded', function () {
			userToolsPromiseAfterChanges = getDropdownData();

			$.when(userToolsPromiseAfterChanges).done(function (userToolsData) {
				var userToolsItems = userToolsData.data;
				loadDropdown(userToolsItems);
			});
		});

		if (!win.Wikia.isTouchScreen()) {
			win.delayedHover(entryPoint[0], {
				onActivate: show,
				onDeactivate: hide,
				activateOnClick: false
			});
		} else {
			entryPoint.on('click', show);
		}
	}

	/**
	 * Create dropdown, add tracking to it and enable customization
	 * @param {Object} userToolsItems - data returned by controller based on which dropdown is built
	 */
	function loadDropdown(userToolsItems) {
		createDropdown(userToolsItems);
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

	/**
	 * @desc shows dropdown
	 * @param {Event=} event
	 */
	function show(event) {
		entryPoint.addClass('active');

		// handle touch interactions
		if (event) {
			event.stopPropagation();
		}

		$('body').one('click', hide);
	}

	/**
	 * @desc hides dropdown
	 */
	function hide() {
		dropdownInstance.resetUI();
		entryPoint.removeClass('active');
	}

	return {
		init: init
	};
});
