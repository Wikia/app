define('ext.wikia.design-system.on-site-notifications.controller', [
		'jquery',
		'wikia.window',
		'wikia.log',
		'ext.wikia.design-system.on-site-notifications.common'
	], function ($, window, log, common) {
		'use strict';

		function Controller(model) {
			this._model = model;
		}

		/**
		 * Gets ISO string from Date
		 * @param {Date} date
		 * @returns {string} - ISO string
		 */
		function convertToIsoString(date) {
			return date.toISOString();
		}

		/**
		 * Gets Date from ISO string date
		 * @param {string} date
		 * @returns {Date} - date
		 */
		function convertToTimestamp(date) {
			return new Date(date);
		}

		function getSafely(obj, path) {
			return path.split(".").reduce(function (acc, key) {
				return (typeof acc == "undefined" || acc === null) ? acc : acc[key];
			}, obj);
		}

		function getTypeFromApiData(notification) {
			if (notification.type === 'upvote-notification') {
				if (notification.refersTo.type === 'discussion-post') {
					return common.notificationTypes.discussionUpvoteReply;
				} else {
					return common.notificationTypes.discussionUpvotePost;
				}
			} else if (notification.type === 'replies-notification') {
				return common.notificationTypes.discussionReply;
			} else if (notification.type === 'announcement-notification') {
				return common.notificationTypes.announcement;
			}
		}

		function createActors(actors) {
			if (!Array.isArray(actors)) {
				return [];
			} else {
				return actors.map(function (data) {
					return {
						avatarUrl: data.avatarUrl,
						badgePermission: data.badgePermission,
						id: data.id,
						name: data.name
					};
				});
			}
		}

		function mapToModel(notifications) {
			return notifications.map(function (notification) {
				return {
					title: getSafely(notification, 'refersTo.title'),
					snippet: getSafely(notification, 'refersTo.snippet'),
					uri: getSafely(notification, 'refersTo.uri'),
					latestEventUri: getSafely(notification, 'events.latestEvent.uri'),
					when: convertToTimestamp(getSafely(notification, 'events.latestEvent.when')),
					communityName: getSafely(notification, 'community.name'),
					communityId: getSafely(notification, 'community.id'),
					isUnread: notification.read === false,
					totalUniqueActors: getSafely(notification, 'events.totalUniqueActors'),
					latestActors: createActors(getSafely(notification, 'events.latestActors')),
					type: getTypeFromApiData(notification)
				};
			});
		}

		Controller.prototype = {

			registerEventHandlers: function (view) {
				view.onLoadMore.attach(this.loadMore.bind(this));
				view.onDropDownClick.attach(this.loadFirstPage.bind(this));
				view.onMarkAllAsReadClick.attach(this.markAllAsRead.bind(this));
				view.onMarkAsReadClick.attach(function (_, uri) {
					this.markAsRead(uri);
				}.bind(this));
			},

			shouldLoadFirstPage: function () {
				return this._model.isLoading() !== true && !this.nextPage && this.allPagesLoaded !== true;
			},

			shouldLoadNextPage: function () {
				return this._model.isLoading() !== true && this.nextPage && this.allPagesLoaded !== true;
			},

			updateUnreadCount: function () {
				$.ajax({
					url: this.getBaseUrl() + '/notifications/unread-count',
					xhrFields: {
						withCredentials: true
					}
				}).done(function (data) {
					this._model.setUnreadCount(data.unreadCount);
				}.bind(this));
			},

			markAsRead: function (id) {
				$.ajax({
					type: 'POST',
					data: JSON.stringify([id.uri]),
					dataType: 'json',
					contentType: "application/json; charset=UTF-8",
					url: this.getBaseUrl() + '/notifications/mark-as-read/by-uri',
					xhrFields: {
						withCredentials: true
					}
				}).done(function () {
					this._model.markAsRead(id.uri);
					this.updateUnreadCount();
				}.bind(this));
			},

			markAllAsRead: function () {
				var since = this._model.getLatestEventTime();
				if (!since) {
					log('Marking as read did not find since ' + this._model, log.levels.info, common.logTag);
					return;
				}
				$.ajax({
					type: 'POST',
					data: JSON.stringify({since: convertToIsoString(since)}),
					dataType: 'json',
					contentType: "application/json; charset=UTF-8",
					url: this.getBaseUrl() + '/notifications/mark-all-as-read',
					xhrFields: {
						withCredentials: true
					}
				}).done(this._model.markAllAsRead.bind(this._model));
			},

			loadFirstPage: function () {
				if (!this.shouldLoadFirstPage()) {
					return;
				}
				this._model.loadingStarted();
				$.ajax({
					url: this.getBaseUrl() + '/notifications',
					xhrFields: {
						withCredentials: true
					}
				}).done(function (data) {
						this._model.addNotifications(mapToModel(data.notifications));
						this.calculatePage(data);
					}.bind(this)
				).always(this._model.loadingStopped.bind(this._model));
			},

			loadMore: function () {
				if (!this.shouldLoadNextPage()) {
					return;
				}
				this._model.loadingStarted();
				$.ajax({
					url: this.getBaseUrl() + this.nextPage,
					xhrFields: {
						withCredentials: true
					}
				}).done(function (data) {
						this._model.addNotifications(mapToModel(data.notifications));
						this.calculatePage(data);
					}.bind(this)
				).always(this._model.loadingStopped.bind(this._model));
			},

			calculatePage: function (data) {
				this.nextPage = getSafely(data, '_links.next');
				if (!this.nextPage) {
					this.allPagesLoaded = true;
				}
			},

			getBaseUrl: function () {
				return window.mw.config.get('wgOnSiteNotificationsApiUrl');
			}
		};

		return Controller
	}
);
