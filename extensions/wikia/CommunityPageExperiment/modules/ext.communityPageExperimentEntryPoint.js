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
			useTasksPage = inCommunityTasksBucket(),
			linkUrl = '/wiki/Special:Community',
			trackingLabel = 'entry-point',
			callToActionMsg = 'communitypageexperiment-entry-tasks',
			buttonMsg = 'communitypageexperiment-entry-learn-more';

		if (useTasksPage) {
			linkUrl = '/wiki/Special:CommunityTasks';
			trackingLabel = 'tasks-entry-point';
		}

		if (mw.user.anonymous()) {
			entryPointHtml += '<span>' + mw.message(callToActionMsg).escaped() + '</span>';
		} else {
			trackingLabel += '-loggedin';
			buttonMsg = 'communitypageexperiment-entry-button';
		}

		entryPointHtml += '<a class="community-page-button" href="' + linkUrl + '">' +
			mw.message(buttonMsg).escaped() + '</a>';

		$('#WikiaPageHeader').find('.header-buttons').append(
			$('<div class="community-page-entry-point">').html(entryPointHtml)
				.on('mousedown touchstart', '.community-page-button', function () {
					trackClick(trackingLabel);
				})
		);
	}

	function inCommunityPageBucket() {
		return abTest.inGroup('COMMUNITY_PAGE_EXPERIMENT', 'COMMUNITY_PAGE_ENTRY_POINT');
	}

	function inCommunityTasksBucket() {
		return abTest.inGroup('COMMUNITY_PAGE_EXPERIMENT', 'COMMUNITY_TASKS_ENTRY_POINT');
	}

	function entryPointEnabled() {
		var inCommunityPageGroup = inCommunityPageBucket(),
			inTestGroups = inCommunityPageGroup || inCommunityTasksBucket(),
			isAnon = mw.user.anonymous(),
			signedUpViaCommunity = cache.get('communityPageSignedUp');

		return (
			(inTestGroups && isAnon) ||
			(
				!isAnon &&
				inCommunityPageGroup &&
				signedUpViaCommunity
			)
		);
	}

	$(function () {
		if (
			mw.config.get('wgNamespaceNumber') === 0 &&
			entryPointEnabled()
		) {
			mw.loader.using('ext.communityPageExperimentEntryPoint').then(addCommunityPageEntryPoint);
		}
	});
});
