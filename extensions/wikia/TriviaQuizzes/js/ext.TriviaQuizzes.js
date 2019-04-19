require(['jquery', 'content_types_consumption', 'wikia.trackingOptIn'], function ($, consumption, trackingOptIn) {
	'use strict';
	$(function() {
		$('.WikiaRail').on('afterLoad.rail', function() {
			// For now: if they are IE11, remove the entire module until we have better support
			if($.browser.msie) {
				$('#wikia-recent-activity').remove();
			} else {
				var cityId = window.wgCityId ? window.wgCityId : 0;
				var dbName = window.wgDBname ? window.wgDBname : null;
				var user = window.wgUserName ? { id: 123, isGDPRApproved: trackingOptIn.isOptedIn() } : null;

				// https://github.com/Wikia/content-types/tree/master/consumption#usage
				consumption.default('wikia-trivia-quizzes', {
					environment: 'media-wiki',
					pageType: 'article',
					user: user,
					community: {
						id: cityId,
						dbName: dbName,
					},
				});
			}
		});
	});
});
