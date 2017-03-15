define('ext.wikia.design-system.on-site-notifications.model', [
		'ext.wikia.design-system.event'
	], function (Event) {
		'use strict';

		function Model() {
			this.markedAllAsRead = new Event(this);
			this.markedAsRead = new Event(this);
			this.notificationsAdded = new Event(this);
			this.loadingStatusChanged = new Event(this);
			this.unreadCountChanged = new Event(this);

			this._loadingNotifications = false;
			this._notifications = [];
			this._unreadCount = 0;

			this.getLatestEventTime = function () {
				var latest = this._notifications[0];
				if (latest) {
					return latest.when;
				} else {
					return null;
				}
			};

			function _setIsUnreadFalse(notification) {
				notification.isUnread = false;
			}

			this.markAsRead = function (id) {
				this._notifications.filter(function (notification) {
					return notification.uri === id && notification.isUnread === true;
				}).forEach(function(notification) {
					this._unreadCount = Math.max(this._unreadCount - 1, 0);
					this._setIsUnreadFalse(notification);
				}.bind(this));
				this.markedAsRead.notify(id);
				this.unreadCountChanged.notify(this._unreadCount);
			};

			this.markAllAsRead = function () {
				this.setUnreadCount(0);
				this._notifications.forEach(_setIsUnreadFalse);
				this.markedAllAsRead.notify();
			};

			this.setUnreadCount = function (count) {
				this._unreadCount = count;
				this.unreadCountChanged.notify(count);
			};

		}

		Model.prototype = {
			loadingStarted: function () {
				this._loadingNotifications = true;
				this.loadingStatusChanged.notify(this._loadingNotifications);
			},

			loadingStopped: function () {
				this._loadingNotifications = false;
				this.loadingStatusChanged.notify(this._loadingNotifications);
			},

			isLoading: function () {
				return this._loadingNotifications;
			},

			addNotifications: function(notifications) {
				this._notifications = this._notifications.concat(notifications);
				this.notificationsAdded.notify({
					list: notifications,
					total: this._notifications.length
				});
			}
		};

		return Model
	}
);
