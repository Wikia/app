require(['wikia.window', 'jquery', 'wikia.tracker', 'wikia.abTest'], function (window, $, tracker, abTest) {
	'use strict';

	$(function () {
		if (abTest.inGroup('PREMIUM_PAGE_HEADER', 'PREMIUM') || window.wgUserName) {
			var track = tracker.buildTrackingFunction({
					category: 'page-header-test-group',
					trackingMethod: 'analytics'
				}),
				$wikiHeader = $('.pph-wiki-header');

			if ($('.PremiumPageHeader').is(':visible')) {
				track({
					action: tracker.ACTIONS.IMPRESSION,
					label: 'wiki-header'
				});
			}

			$wikiHeader.find('.wordmark').on('click', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'wordmark-image'
				});
			});

			$wikiHeader.find('.pph-wordmark-text').on('click', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'wordmark-text'
				});
			});

			$wikiHeader.find('.pph-tally').on('click', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'tally'
				});
			});

			$wikiHeader.find('.pph-add-new-page').on('click', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'add-new-page'
				});
			});

			$wikiHeader.find('.pph-admin-tools-wiki-activity').on('click', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'admin-tools-wiki-activity'
				});
			});
		}
	});
});
