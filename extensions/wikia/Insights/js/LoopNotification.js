/*
 * Script for adding BannerNotification that encourages user to continue working
 * on issues reported by Insights feature
 */

/* global require */
require(['jquery', 'BannerNotification'], function ($, BannerNotification) {
	'use strict';

	var bannerNotification, showNotification;

	bannerNotification = new BannerNotification();

	showNotification = function showNotification(html) {
		bannerNotification.setContent(html).show();
	};

	$.nirvana.sendRequest({
		controller: 'Insights',
		method: 'LoopNotification',
		format: 'html',
		type: 'get',
		callback: showNotification
	});

});
