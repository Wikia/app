/*
 * Script for adding BannerNotification that encourages user to continue working
 * on issues reported by Insights feature
 */

/* global require */
require(
	[
		'jquery',
		'BannerNotification',
		'wikia.querystring',
		'wikia.window',
		'ext.wikia.Insights.LoopNotificationTracking'
	],
	function ($, BannerNotification, Querystring, window, loopNotificationTracking)
{
	'use strict';

	var qs = new Querystring(),
		insights = qs.getVal('insights', null),
		isVE = qs.getVal('veaction', null),
		isFixed = qs.getVal('item_status', null),
		initNotification,
		showNotification,
		onShowNotification,
		getNotificationType,
		getParent;

	showNotification = function(html) {
		if (html) {
			var msgType = getNotificationType(),
				$parent = getParent(),
				bn;

			bn = new BannerNotification(html, msgType, $parent);
			bn.onShow(onShowNotification);
			bn.show();
		}
	};

	onShowNotification = function(event, bannerNotification) {
		bannerNotification.$element.find('#InsightsNextPageButton').focus();
		// TODO pass notificationType as tracking param
		loopNotificationTracking.init(event, bannerNotification);
	}

	getNotificationType = function() {
		if (window.wgIsEditPage || isFixed === 'notfixed') {
			return 'warn';
		} else {
			return 'confirm';
		}
	};

	getParent = function() {
		if (window.wgIsEditPage) {
			return $('#WikiaMainContent');
		} else {
			return null;
		}
	};

	initNotification = function() {
		$.nirvana.sendRequest({
			controller: 'Insights',
			method: 'loopNotification',
			format: 'html',
			type: 'get',
			data: {
				insight: insights,
				isEdit: window.wgIsEditPage,
				isFixed: isFixed,
				article: window.wgPageName
			},
			callback: showNotification
		});
	};

	$(function () {
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
});
