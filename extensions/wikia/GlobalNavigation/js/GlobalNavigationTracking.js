$(function($) {
	'use strict';
	var searchSuggestionsShowed, track, $globalNavigation, $globalNavigationSearch;

	$globalNavigation = $('#globalNavigation');
	$globalNavigationSearch = $globalNavigation.find('#searchForm');
	searchSuggestionsShowed = false;

	function globalNavigationClickTrackingHandler(event) {
		var $element, label, $parent;

		//Track only primary mouse button click
		if (event.type === 'mousedown' && event.which !== 1) {
			return;
		}

		track = Wikia.Tracker.buildTrackingFunction({
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'top-nav',
			trackingMethod: 'ga'
		});

		$element = $(event.target);
		if ($element.closest('.wikia-logo').length > 0) {
			label = 'wikia-logo';
		} else if ($element.closest('.hub-links').length > 0 || $element.closest('.hub-list').length > 0) {
			label = 'hub-item';
		} else if ($element.data('id') === 'logout') {
			label = 'user-menu-logout';
		} else if ($element.data('id') === 'help') {
			label = 'user-menu-help';
		} else if ($element.data('id') === 'preferences') {
			label = 'user-menu-preferences';
		} else if ($element.data('id') === 'mytalk') {
			label = 'user-menu-talk';
		} else if ($element.closest('.ajaxRegisterContainer').length > 0) {
			label = 'register';
		} else if ($element.closest('.notifications-for-wiki').length > 0) {
			$parent = $element.closest('.notifications-for-wiki');
			if ($parent.data('wiki-id') === parseInt(window.wgCityId)) {
				label = 'notification-item-local';
			} else {
				label = 'notification-item-cross-wiki';
			}
		} else if ($element.hasClass('message-wall')) {
			label = 'user-menu-message-wall';
		} else if ($element.closest('.start-wikia').length > 0) {
			label = 'start-a-wiki';
		} else if ($element.hasClass('login-button')) {
			label = 'login';
		} else if ($element.closest('.ajaxLogin').attr('accesskey') === '.') {
			label = 'user-menu-profile';
		} else {
			//If none of above was clicked, don't track
			return;
		}

		track({
			label: label
		});
	}

	function searchSuggestionsClickTrackingHandler(event) {
		if (event.type === 'mousedown' && event.which !== 1) {
			return;
		}

		trackSearch({
			browserEvent: event,
			label: 'search-suggest'
		});
	}

	function searchSubmitButtonClickTrackingHandler(event) {
		if (event.which === 1 && event.clientX > 0) {
			trackSearch({
				label: !searchSuggestionsShowed ? 'search-button' : 'search-after-suggest-button'
			});
		}
	}

	function searchSubmitEnterPressTrackingHandler(event) {
		if (event.which === 13 && $(this).is(':focus') ) {
			trackSearch({
				label: !searchSuggestionsShowed ? 'search-enter' : 'search-after-suggest-enter'
			});
		}
	}

	function searchSuggestionsEnterPressOnSuggestionsTrackingHandler() {
		trackSearch({
			label: 'search-suggest-enter'
		});
	}

	function searchSuggestionsShowedTrackingHandler() {
		searchSuggestionsShowed = true;

		trackSearch({
			action: Wikia.Tracker.ACTIONS.VIEW,
			label: 'search-suggest-show'
		});
	}

	function trackSearch(data) {
		track = Wikia.Tracker.buildTrackingFunction({
			category: 'search',
			trackingMethod: 'both'
		});
		data.action = data.action || Wikia.Tracker.ACTIONS.CLICK;

		track(data);
	}

	$globalNavigation.on('mousedown touchstart', globalNavigationClickTrackingHandler);
	$globalNavigationSearch
		.on('mousedown touchstart', '.autocomplete', searchSuggestionsClickTrackingHandler)
		.on('mousedown touchstart', '.search-submit', searchSubmitButtonClickTrackingHandler)
		.on('keypress', '[name=search]', searchSubmitEnterPressTrackingHandler)
		.on('suggestEnter', searchSuggestionsEnterPressOnSuggestionsTrackingHandler)
		.one('suggestShow', searchSuggestionsShowedTrackingHandler);
});
