require(['jquery', 'content_types_consumption'], function ($, consumption) {
	'use strict';
	$(function() {
		$('.WikiaRail').on('afterLoad.rail', function() {
			consumption.default('wikia-trivia-quizzes', {
				user: {
					id: 0,
					isGDPRApproved: true,
				},
			});
		});
	});
});
