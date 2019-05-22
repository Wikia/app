require(['jquery', 'content_types_consumption', 'wikia.trackingOptIn', 'mw'], function ($, consumption, trackingOptIn, mw) {
	'use strict';
	$(function () {
		$('.WikiaRail').on('afterLoad.rail', function () {
			// do nothing if there's no module
			if ($('#wikia-trivia-quizzes').length) {
				// FIXME: For now: if they are IE11, remove the entire module until we have better support
				if ($.browser.msie) {
					$('#wikia-recent-activity').remove();
				} else {
					// https://github.com/Wikia/content-types/tree/master/consumption#usage
					consumption.default('wikia-trivia-quizzes', {
						environment: 'media-wiki',
						pageType: 'Article',
						user: {
							id: mw.config.get('wgUserId') || 0,
							isGDPRApproved: trackingOptIn.isOptedIn(),
						},
						community: {
							dbName: mw.config.get('wgDBname') || null,
							id: mw.config.get('wgCityId') || '0',
						},
						theme: {
							primaryColor: mw.config.get('wgTriviaQuizzesPrimaryColor'),
						},
					});
				}
			}
		});
	});
});
