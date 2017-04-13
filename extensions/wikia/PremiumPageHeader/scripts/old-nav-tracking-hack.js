require(['wikia.window', 'jquery', 'wikia.tracker', 'wikia.abTest'], function (window, $, tracker, abTest) {
	'use strict';

	var $oldWikiHeader = $('#WikiHeader'),
		$oldArticleHeader = $('#WikiaPageHeader'),
		track = tracker.buildTrackingFunction({
			category: 'page-header-control',
			trackingMethod: 'analytics'
		});

	function trackClick(label) {
		track({
			action: tracker.ACTIONS.CLICK,
			label: label
		});
	}

	$(function () {
		if (abTest.inGroup('PREMIUM_PAGE_HEADER', 'CONTROL') && !window.wgUserName) {
			if ($oldWikiHeader.is(':visible')) {
				track({
					action: tracker.ACTIONS.IMPRESSION,
					label: 'wiki-header'
				});
			}
			// wordmark-image
			$oldWikiHeader.find('.wordmark').on('click', function () {
				trackClick('wordmark-image');
			});
			// wordmark-text - n/a
			// tally
			$oldArticleHeader.find('.tally').on('click', function () {
				trackClick('tally');
			});
			// add-new-page
			$oldArticleHeader.find('.createpage').on('click', function () {
				trackClick('add-new-page');
			});
			// custom-level-1, explore-menu
			$oldWikiHeader.find('.nav-item > a').on('click', function () {
				var $parent = $(this).parent();
				if ($parent.hasClass('marked')) {
					if ($parent.find('.subnav-2a').data('canonical')) {
						trackClick('explore-menu');
					} else {
						trackClick('custom-level-1');
					}
				}
			});
			// custom-level-2, exlopre-<special page>, discuss
			$oldWikiHeader.find('.subnav-2a').on('click', function () {
				var data = $(this).data('canonical'),
					href = $(this).attr('href');
				if (data) {
					trackClick('explore-' + data.replace('wiki', ''));
				} else if (href === '/d' || href.startsWith('/d/')) {
					trackClick('discuss');
				} else {
					trackClick('custom-level-2');
				}
			});
			// custom-level-3
			$oldWikiHeader.find('.subnav-3a').on('click', function () {
				trackClick('custom-level-3');
			});

			// edit
			$oldArticleHeader.find('.wikia-menu-button > a').on('click', function () {
				trackClick('edit');
			});
			// edit-dropdown
			$oldArticleHeader.find('.wikia-menu-button .drop').on('click', function () {
				trackClick('edit-dropdown');
			});
			// edit-<action>
			$oldArticleHeader.find('.wikia-menu-button .WikiaMenuElement a').on('click', function () {
				var data = $(this).data('id');
				trackClick('edit-' + data);
			});
			// edit-mobile-page
			$oldArticleHeader.find('#CuratedContentTool').on('click', function () {
				trackClick('edit-mobile-page');
			});
			// comments
			$oldArticleHeader.find('a.comments').on('click', function () {
				trackClick('comments');
			});
			// share
			$oldArticleHeader.find('#ShareEntryPoint').on('click', function () {
				trackClick('share');
			});
		}
	});
});
