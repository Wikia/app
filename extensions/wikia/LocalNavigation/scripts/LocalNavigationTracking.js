(function($){
	'use strict';
	var $localNav, track;

	track = window.Wikia.Tracker.buildTrackingFunction({
		action: window.Wikia.Tracker.ACTIONS.CLICK,
		trackingMethod: 'analytics'
	});

	$localNav = $('#localNavigation');

	function trackWordmarkEvent(event) {
		// Track only primary mouse button click
		if (event.which !== 1) {
			return;
		}

		track({
			browserEvent: event,
			category: 'wiki-nav',
			label: 'wordmark'
		});
	}

	function trackNavigationDropdownEvent(event) {
		var $element = $(event.currentTarget),
			canonical = $element.data('canonical'),
			label;

		// Track only primary mouse button click
		if (event.which !== 1) {
			return;
		}

		if (canonical !== undefined) {
			switch (canonical) {
				case 'wikiactivity':
					label = 'on-the-wiki-activity';
					break;
				case 'random':
					label = 'on-the-wiki-random';
					break;
				case 'newfiles':
					label = 'on-the-wiki-new-photos';
					break;
				case 'chat':
					label = 'on-the-wiki-chat';
					break;
				case 'forum':
					label = 'on-the-wiki-forum';
					break;
				case 'videos':
					label = 'on-the-wiki-videos';
					break;
			}
		} else if ($element.closest('.third-level-menu').length === 1) {
			label = 'custom-level-3';
		} else if ($element.closest('.second-level-menu').length === 1) {
			label = 'custom-level-2';
		} else if ($element.closest('.first-level-menu').length === 1) {
			label = 'custom-level-1';
		}

		if (label !== undefined) {
			track({
				browserEvent: event,
				category: 'wiki-nav',
				label: label
			});
		}
	}

	$('.wordmark-container', $localNav).on('mousedown', 'a', trackWordmarkEvent);
	$('.local-nav', $localNav).on('mousedown', 'a', trackNavigationDropdownEvent);
})(jQuery);

