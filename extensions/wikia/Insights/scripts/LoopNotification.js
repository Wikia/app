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
			notification,
			notificationType,
			// Functions
			initNotification,
			showNotification,
			getMessageType,
			getParent,
			addInsightsFlowToEditButtons;

		showNotification = function(response) {
			if (response) {
				var msgType,
					$parent = getParent();

				isFixed = response.isFixed;
				msgType = getMessageType();

				if (notificationType !== response.notificationType) {
					notificationType = response.notificationType;

					if (notificationType === 'notfixed') {
						addInsightsFlowToEditButtons();
					}

					if (notification) {
						notification.hide();
					}
					notification = new BannerNotification(response.html, msgType, $parent).show();
				}

				loopNotificationTracking.setParams(isEdit, isFixed, notificationType);


				if (notificationType === 'fixed') {
					$('#InsightsNextPageButton').focus();
				} else if (notificationType === 'notfixed') {
					$('#InsightsEditPageButton').focus();
				}
			}
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

		addInsightsFlowToEditButtons = function() {
			var self,
				href = '',
				pathname = document.location.pathname,
				param = '&insights=' + insights;

			$('a[href*="action=edit"]').each(function(){
				self = $(this);
				href = self.attr('href');
				if (href.indexOf(pathname) !== -1) {
					self.attr('href', href + param);
				}
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

			loopNotificationTracking.init();
		}
	});
});
