require(['jquery', 'wikia.tracker'], function ($, tracker) {
	'use strict';

	$(function () {
		$('#CommunityPageEntryPoint').find('.community-page-button').on('mousedown', function () {
			tracker.track({
				category: 'community-page',
				action: tracker.ACTIONS.CLICK_LINK_BUTTON,
				label: 'entry-point',
				trackingMethod: 'analytics'
			});
		});
	});
});

/* For dynamically adding it if we use internal ABTesting
mw.loader.using('ext.communityPageExperimentEntryPoint').then(function () {
	$('#WikiaPageHeader').find('.header-buttons').append(
		$('<div class="community-page-entry-point" id="CommunityPageEntryPoint">')
			.append(
				$('<span>').text('Join this community!'),
				$('<a class="community-page-button">').attr('href', '/wiki/Special:Community').text('Learn more')
			)
	);
});
 */
