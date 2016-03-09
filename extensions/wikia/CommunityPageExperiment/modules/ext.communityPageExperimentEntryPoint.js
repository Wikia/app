require([
	'jquery',
	'mw',
	'wikia.abTest',
	'wikia.cache',
	'wikia.tracker'
], function ($, mw, abTest, cache, tracker) {
	'use strict';

	function trackClick(label) {
		tracker.track({
			category: 'community-page',
			action: tracker.ACTIONS.CLICK_LINK_BUTTON,
			label: label,
			trackingMethod: 'analytics'
		});
	}

	function addCommunityPageEntryPoint() {
		var entryPointHtml = '',
			trackingLabel = 'entry-point',
			buttonMsg = 'communitypageexperiment-entry-learn-more';

		if (mw.user.anonymous()) {
			entryPointHtml += '<span>' + mw.message('communitypageexperiment-entry-join').escaped() + '</span>';
		} else {
			trackingLabel += '-loggedin';
			buttonMsg = 'communitypageexperiment-entry-button';
		}

		entryPointHtml += '<a class="community-page-button" href="/wiki/Special:Community">' +
			mw.message(buttonMsg).escaped() + '</a>';

		$('#WikiaPageHeader').find('.header-buttons').append(
			$('<div class="community-page-entry-point">').html(entryPointHtml)
				.on('mousedown touchstart', '.community-page-button', function () {
					trackClick(trackingLabel);
				})
		);
	}

	$(function () {
		var inTestGroup = abTest.inGroup('COMMUNITY_PAGE_EXPERIMENT', 'COMMUNITY_PAGE_ENTRY_POINT'),
			isAnon = mw.user.anonymous(),
			signedUpViaCommunity = cache.get('communityPageSignedUp');

		if (
			mw.config.get('wgNamespaceNumber') === 0 &&
			inTestGroup &&
			(isAnon || (!isAnon && signedUpViaCommunity))
		) {
			mw.loader.using('ext.communityPageExperimentEntryPoint').then(addCommunityPageEntryPoint);
		}
	});
});
