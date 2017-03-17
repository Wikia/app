require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	$(function () {
		var track = tracker.buildTrackingFunction({
				category: 'page-header-test-group',
				trackingMethod: 'analytics'
			}),
			$wikiHeader = $('.pph-wiki-header');

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
	});
});
