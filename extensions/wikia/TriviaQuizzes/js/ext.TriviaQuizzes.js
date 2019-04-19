require(['jquery', 'mw', 'content_types_consumption'], function ($, mw, consumption) {
	'use strict';
	$(function () {
		consumption.default('PageHeader', {
			user: {
				id: 0,
				isGDPRApproved: true,
			},
		});

		// load the thing

		//railModule('wikia-recent-activity');
	});
});
