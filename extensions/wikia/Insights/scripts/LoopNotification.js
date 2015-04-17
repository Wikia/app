/*
 * Script for adding BannerNotification that encourages user to continue working
 * on issues reported by Insights feature
 */

/* global require */
require(['jquery', 'BannerNotification', 'wikia.querystring'], function ($, BannerNotification, Querystring) {
	'use strict';

	var bannerNotification = new BannerNotification(),
		qs = new Querystring(),
		insights = qs.getVal('insights', null),
		isVE = qs.getVal('veaction', null),
		initNotification,
		showNotification;

	showNotification = function showNotification(html) {
		if (html) {
			bannerNotification.setContent(html).show();
		}
	};

	initNotification = function() {
		$.nirvana.sendRequest({
			controller: 'Insights',
			method: 'loopNotification',
			format: 'html',
			type: 'get',
			data: {
				insight: insights
			},
			callback: showNotification
		});
	};

	if (insights) {
		if (isVE) {
			window.mw.hook('ve.deactivationComplete').add(function(saved){
				if (saved) {
					initNotification();
				}
			});
		} else {
			initNotification();
		}
	}
});
