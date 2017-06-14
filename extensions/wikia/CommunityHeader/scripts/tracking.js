require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		category: 'community-header',
		trackingMethod: 'analytics',
		action: tracker.ACTIONS.CLICK
	});

	var $communityHeader = $('.wds-community-header');

	function initTracking() {
		$('.wds-community-header__local-navigation').on('click', 'a', function () {
			var $this = $(this);
			if ($this.data('tracking')) {
				track({label: $this.data('tracking')});
			} else {
				var level = $this.parentsUntil('.wds-community-header__local-navigation', 'ul').length;
				track({label: 'custom-level-' + level});
			}
		});

		$communityHeader.find('.wds-community-header__wordmark a').on('click', function () {
			track({
				label: 'wordmark-image'
			});
		});

		$communityHeader.find('.wds-community-header__sitename a').on('click', function () {
			track({
				label: 'sitename'
			});
		});

		$communityHeader.find('.wds-community-header__counter').on('click', function () {
			track({
				label: 'counter'
			});
		});

		$communityHeader.find('.wds-community-header__wiki-buttons').on('click', 'a', function () {
			track({label: $(this).data('tracking')});
		});
	}

	$(function () {
		initTracking();
	});
});
