$(function ($) {
	'use strict';
	var searchSuggestionsShowed, track, $globalNavigation, $globalNavigationSearch;

	$globalNavigation = $('#globalNavigation');
	$globalNavigationSearch = $globalNavigation.find('#searchForm');
	searchSuggestionsShowed = false;

	/**
	 * Tracking helper function with most commonly used options. Overrides are passed in by callers.
	 */
	track = Wikia.Tracker.buildTrackingFunction({
		category: 'search',
		trackingMethod: 'analytics',
		action: Wikia.Tracker.ACTIONS.CLICK
	});

	/**
	 * Parent click handler for events in the global nav
	 * @param {object} event
	 */
	function globalNavigationClickTrackingHandler(event) {
		var $element, label;

		//Track only primary mouse button click
		if (event.type === 'mousedown' && event.which !== 1) {
			return;
		}

		$element = $(event.target);

		label = getLabelByIdentifier($element) ||
			getLabelByDOM($element);

		if (label !== false) {
			track({
				category: 'top-nav',
				label: label
			});
		}
	}

	/**
	 * Get the label for tracking based on data-id attribute
	 * @param {jQuery} $element
	 * @returns {string|boolean}
	 */
	function getLabelByIdentifier($element) {
		//Get element's data id or get data-id from closest element with this attribute
		var dataId = $element.data('id') || $element.closest('[data-id]').data('id'),
			map = {
				'logout': 'user-menu-logout',
				'help': 'user-menu-help',
				'preferences': 'user-menu-preferences',
				'facebook': 'facebook',
				'register': 'register',
				'start-wikia': 'start-a-wiki',
				'wikia-logo': 'wikia-logo',
				'mytalk': (function () {
					return $element.hasClass('message-wall') ?
						'user-menu-message-wall' :
						'user-menu-talk';
				})()
			};

		return map[dataId] || false;
	}

	/**
	 * Get the label for tracking based on surrounding DOM of clicked element
	 * @param {jQuery} $element
	 * @returns {string|boolean}
	 */
	function getLabelByDOM($element) {
		var label = false,
			$parent;

		if ($element.closest('.hub-links').length > 0 || $element.closest('.hub-list').length > 0) {
			label = 'hub-item';
		} else if ($element.closest('.notifications-for-wiki').length > 0) {
			$parent = $element.closest('.notifications-for-wiki');
			if ($parent.data('wiki-id') === parseInt(window.wgCityId)) {
				label = 'notification-item-local';
			} else {
				label = 'notification-item-cross-wiki';
			}
		} else if ($element.hasClass('login-button')) {
			label = 'login';
		} else if ($element.closest('.ajaxLogin').attr('accesskey') === '.') {
			label = 'user-menu-profile';
		}

		return label;
	}

	function searchSuggestionsClickTrackingHandler(event) {
		if (event.type === 'mousedown' && event.which !== 1) {
			return;
		}

		track({
			browserEvent: event,
			label: 'search-suggest'
		});
	}

	function searchSubmitButtonClickTrackingHandler(event) {
		if (event.which === 1 && event.clientX > 0) {
			track({
				label: !searchSuggestionsShowed ? 'search-button' : 'search-after-suggest-button'
			});
		}
	}

	function searchSubmitEnterPressTrackingHandler(event) {
		if (event.which === 13 && $(event.target).is(':focus')) {
			track({
				label: !searchSuggestionsShowed ? 'search-enter' : 'search-after-suggest-enter'
			});
		}
	}

	function searchSuggestionsEnterPressOnSuggestionsTrackingHandler() {
		track({
			label: 'search-suggest-enter'
		});
	}

	function searchSuggestionsShowedTrackingHandler() {
		searchSuggestionsShowed = true;

		track({
			action: Wikia.Tracker.ACTIONS.VIEW,
			label: 'search-suggest-show'
		});
	}

	$globalNavigation.on('mousedown touchstart', globalNavigationClickTrackingHandler);
	$globalNavigationSearch
		.on('mousedown touchstart', '.autocomplete', searchSuggestionsClickTrackingHandler)
		.on('mousedown touchstart', '.search-button', searchSubmitButtonClickTrackingHandler)
		.on('keypress', '[name=search]', searchSubmitEnterPressTrackingHandler)
		.on('suggestEnter', searchSuggestionsEnterPressOnSuggestionsTrackingHandler)
		.one('suggestShow', searchSuggestionsShowedTrackingHandler);
});
