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
			trackingMethod: 'analytics'
		});

		$('#userToolsDropdown').on('mousedown touchstart', 'a', function (e) {
			var label,
				el = e.target,
				name = $(el).data('name'),
				action = tracker.ACTIONS.CLICK,
				category = 'toolbar';

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
				case 'edit-a-page':
				case 'add-a-video':
				case 'add-a-photo':
				case 'add-a-page':
				case 'wiki-activity':
				case 'edit-wiki-navigation':
					label = name;
					category = 'contribute';
					break;
				case 'create-map-clicked':
					label = name;
					action = 'click-link-button';
					category = 'map';
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
					action: action,
					category: category,
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
		$('.article-navigation > ul > li.active').removeClass('active');

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
