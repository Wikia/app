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

	$(function () {
		var qs = new Querystring(),
			insights = qs.getVal('insights', null),
			isVE = qs.getVal('veaction', null),
			isFixed = false,
			isEdit = false,
			initNotification,
			showNotification,
			onShowNotification,
			notification,
			notificationType,
			getMessageType,
			getParent;

		showNotification = function(response) {
			if (response) {
				var msgType,
					$parent = getParent();

				isFixed = response.isFixed;
				msgType = getMessageType();

				if (notificationType !== response.notificationType) {
					notificationType = response.notificationType;

					if (notification) {
						notification.hide();
					}
					notification = new BannerNotification(response.html, msgType, $parent);
					notification.onShow(onShowNotification);
					notification.show();
				}

				$('#InsightsNextPageButton').focus();
			}
		};

		onShowNotification = function(event, bannerNotification) {
			bannerNotification.$element.find('#InsightsNextPageButton').focus();
			// TODO pass notificationType as tracking param
			loopNotificationTracking.init(event, bannerNotification);
		};

		getMessageType = function() {
			if (isEdit || !isFixed) {
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
				type: 'get',
				data: {
					insight: insights,
					isEdit: isEdit,
					article: window.wgPageName
				},
				callback: showNotification
			});
		};


		if (insights) {
			if (isVE) {
				window.mw.hook('ve.deactivationComplete').add(function(saved){
					if (saved) {
						isEdit = false;
						initNotification();
					}
				});

				window.mw.hook('ve.activationComplete').add(function(){
					isEdit = true;
					initNotification();
				});

			} else {
				isEdit = window.wgIsEditPage;
				initNotification();
			}
		}
	});
});
