$(function($) {
	'use strict';
	var searchSuggestionsShowed, track, $globalNavigation, $globalNavigationSearch;

	$globalNavigation = $('#globalNavigation');
	$globalNavigationSearch = $globalNavigation.find('#searchForm');
	searchSuggestionsShowed = false;

	function globalNavigationClickTrackingHandler(event) {
		var $element;

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
		if ($element.closest('.wikia-logo').length > 0) { // wikia logo
			track({
				label: 'wikia-logo'
			});
		} else if ($element.closest('.hub-links').length > 0 || $element.closest('.hub-list').length > 0) { // hub link
			track({
				label: 'hub-item'
			});
		} else if ($element.data('id') === 'logout') {
			track({
				label: 'user-menu-logout'
			});
		} else if ($element.data('id') === 'help') {
			track({
				label: 'user-menu-help'
			});
		} else if ($element.hasClass('message-wall')) {
			track({
				label: 'user-menu-message-wall'
			});
		} else if ($element.closest('.start-wikia').length > 0) { //start a wikia button
			track({
				label: 'start-wiki'
			});
		} else if ($element.hasClass('login-button')) { // log in button
			track({
				label: 'login'
			});
		} else if ($element.closest('.ajaxLogin').attr('accesskey') === '.') { //user menu profile
			track({
				label: 'user-menu-profile'
			});
		}
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
