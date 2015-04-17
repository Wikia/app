/*
 * Script for adding BannerNotification that encourages user to continue working
 * on issues reported by Insights feature
 */

/* global require */
require(['jquery', 'BannerNotification', 'wikia.querystring'], function ($, BannerNotification, Querystring) {
	'use strict';

	var bannerNotification = new BannerNotification(),
		qs = new Querystring(),
		showNotification;

	showNotification = function showNotification(html) {
		if (html) {
			bannerNotification.setContent(html).show();
			$('#InsightsNextPageButton').focus();
		}
	};

	$.nirvana.sendRequest({
		controller: 'Insights',
		method: 'loopNotification',
		format: 'html',
		type: 'get',
		data: {
			insight: qs.getVal('insights')
		},
		callback: showNotification
	});

});
