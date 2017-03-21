define('ext.wikia.design-system.on-site-notifications.tracking', [
		'wikia.log',
		'ext.wikia.design-system.on-site-notifications.common'
	], function (log, common) {
		'use strict';

		function Tracking() {
		}

		Tracking.prototype = {

			notificationImpression: function (uri) {
				log('impression - notification ' + uri, log.levels.info, common.logTag);
				console.log('impression - notification ' + uri);
			},

			notificationClick: function (uri) {
				log('click - notification ' + uri, log.levels.info, common.logTag);
				console.log('click - notification ' + uri);
			},

			markAllAsReadClick: function () {
				log('click - Mark all as read', log.levels.info, common.logTag);
				console.log('clicked - Mark all as read');
			},

			markAsReadClick: function (uri) {
				log('click - Mark as read ' + uri, log.levels.info, common.logTag);
				console.log('clicked - Mark as read ' + uri);
			},

			registerEventHandlers: function (view) {
				view.onMarkAllAsReadClick.attach(this.markAllAsReadClick.bind(this));
				view.onMarkAsReadClick.attach(function (_, uri) {
					this.markAsReadClick(uri);
				}.bind(this));
				view.onNotificationRender.attach(function (_, uri) {
					this.notificationImpression(uri);
				}.bind(this));
				view.onNotificationClick.attach(function (_, uri) {
					this.notificationClick(uri);
				}.bind(this));
			}
		};

		return Tracking
	}
);
