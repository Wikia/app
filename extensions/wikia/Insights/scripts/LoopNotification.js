/*
 * Script for adding BannerNotification that encourages user to continue working
 * on issues reported by Insights feature
 */

/* global require */
require(['jquery', 'BannerNotification', 'wikia.querystring', 'wikia.window'],
	function ($, BannerNotification, Querystring, window)
{
	'use strict';

	$(function () {
		var qs = new Querystring(),
			insights = qs.getVal('insights', null),
			isVE = qs.getVal('veaction', null),
			isFixed = qs.getVal('item_status', null),
			isEdit = false,
			initNotification,
			showNotification,
			getNotificationType,
			getParent;

		showNotification = function(html) {
			if (html) {
				var msgType = getNotificationType(),
					$parent = getParent();

				new BannerNotification(html, msgType, $parent).show();
				$('#InsightsNextPageButton').focus();
			}
		};

		getNotificationType = function() {
			if (isEdit || isFixed === 'notfixed') {
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
					isEdit: isEdit,
					isFixed: isFixed,
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
