require(['wikia.window', 'jquery', 'wikia.tracker'], function (window, $, tracker) {
	'use strict';

	var $oldWikiHeader = $('#WikiHeader'),
		$oldArticleHeader = $('#WikiaPageHeader'),
		trackClick = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			category: 'page-header-control',
			trackingMethod: 'analytics'
		});

	$(function () {
		//TODO: introduce impression track
		// wordmark-image
		$oldWikiHeader.find('.wordmark').on('click', function () {
			trackClick({label: 'wordmark-image'});
		});
		// wordmark-text - n/a
		// tally
		$oldArticleHeader.find('.tally').on('click', function () {
			trackClick({label: 'tally'});
		});
		// add-new-page
		$oldArticleHeader.find('.createpage').on('click', function () {
			trackClick({label: 'add-new-page'});
		});
		// custom-level-1, explore-menu
		$oldWikiHeader.find('.nav-item > a').on('click', function () {
			var $parent = $(this).parent();
			if ($parent.hasClass('marked')) {
				if ($parent.find('.subnav-2a').data('canonical')) {
					trackClick({label: 'explore-menu'});
				} else {
					trackClick({label: 'custom-level-1'});
				}
			}
		});
		// custom-level-2, exlopre-<special page>, discuss
		$oldWikiHeader.find('.subnav-2a').on('click', function () {
			var data = $(this).data('canonical'),
				href = $(this).attr('href');
			if (data) {
				trackClick({label: 'explore-' + data.replace('wiki', '')});
			} else if (href === '/d' || href.startsWith('/d/')) {
				trackClick({label: 'discuss'});
			} else {
				trackClick({label: 'custom-level-2'});
			}
		});
		// custom-level-3
		$oldWikiHeader.find('.subnav-3a').on('click', function () {
			trackClick({label: 'custom-level-3'});
		});
		// categories-in
		$('.special-categories').on('click', function () {
			trackClick({label: 'categories-in'});
		});
		// categories-<number>
		$('#articleCategories').find('li.category a').on('click', function () {
			var index = $('#articleCategories').find('li.category:not(.hidden)').index($(this).closest('.category'));
			trackClick({label: 'categories-' + index});
		});
		// categories-more - n/a
		// categories-more-<number> - n/a
		// interwiki-dropdown - n/a
		// interwiki-<lang code> - n/a
		// edit
		$oldArticleHeader.find('.wikia-menu-button > a').on('click', function () {
			trackClick({label: 'edit'});
		});
		// edit-dropdown
		$oldArticleHeader.find('.wikia-menu-button .drop').on('click', function () {
			trackClick({label: 'edit-dropdown'});
		});
		// edit-<action>
		$oldArticleHeader.find('.wikia-menu-button .WikiaMenuElement a').on('click', function () {
			var data = $(this).data('id');
			trackClick({label: 'edit-' + data});
		});
		// edit-mobile-page
		$oldArticleHeader.find('#CuratedContentTool').on('click', function () {
			trackClick({label: 'edit-mobile-page'});
		});
		// comments
		$oldArticleHeader.find('a.comments').on('click', function () {
			trackClick({label: 'comments'});
		});
		// share
		$oldArticleHeader.find('#ShareEntryPoint').on('click', function () {
			trackClick({label: 'share'});
		});
	});
});
