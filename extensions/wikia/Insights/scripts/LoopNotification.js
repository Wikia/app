/*
 * Script for adding BannerNotification that encourages user to continue working
 * on issues reported by Insights feature
 */

/* global require */
require(['jquery', 'BannerNotification', 'wikia.querystring'], function ($, BannerNotification, Querystring) {
	'use strict';

	var bannerNotification, showNotification,
		qs = new Querystring();

	bannerNotification = new BannerNotification();

	showNotification = function showNotification(html) {
		if ( html ) {
			bannerNotification.setContent(html).show();
		}
	};

	console.log(qs.getVal('insights'));

	$.nirvana.sendRequest({
		controller: 'Insights',
		method: 'LoopNotification',
		format: 'html',
		type: 'get',
		data: {
			insight: qs.getVal('insights')
		},
		callback: showNotification
	});

});
