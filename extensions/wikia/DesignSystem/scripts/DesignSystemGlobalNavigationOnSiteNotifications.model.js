define('ext.wikia.design-system.on-site-notifications.model', [
	'jquery'
	], function ($) {
		'use strict';

		function Model(view) {
			this.view = view;
			this.notifications = [];
			this.unreadCount = 0;

			this.getLatestEventTime = function () {
				var latest = this.notifications[0];
				if (latest) {
					return latest.when;
				} else {
					return null;
				}
			};

			function setIsUnreadFalse(notification) {
				notification.isUnread = false;
			}

			this.markAsRead = function (id) {
				this.notifications.filter(function (notification) {
					return notification.uri === id;
				}).forEach(setIsUnreadFalse);
				this.view.renderNotificationAsRead(id);
			};

			this.markAllAsRead = function () {
				this.setUnreadCount(0);
				this.notifications.forEach(setIsUnreadFalse);
				this.view.renderAllNotificationsAsRead();
			};

			this.setUnreadCount = function (count) {
				this.unreadCount = count;
				this.view.renderUnreadCount(count);
			};

			this.addNotifications = function (notifications) {
				this.notifications = this.notifications.concat(notifications);
				if (this.notifications.length > 0) {
					this.view.renderNotifications(notifications);
				} else {
					this.view.renderZeroState();
				}
			};

			this.proxy = function (func) {
				//TODO replace proxy with .bind and remove jquery from dependencies
				return $.proxy(func, this);
			}
		}

		return Model
	}
);
