define('ext.wikia.design-system.on-site-notifications.controller', [
		'jquery',
		'wikia.window',
		'wikia.log',
		'ext.wikia.design-system.on-site-notifications.common'
	], function ($, window, log, common) {
		'use strict';

		function Controller(model) {
			this.model = model;

			this.shouldLoadFirstPage = function () {
				return this.model.isLoading() !== true && !this.nextPage && this.allPagesLoaded !== true;
			};

			this.shouldLoadNextPage = function () {
				return this.model.isLoading() !== true && this.nextPage && this.allPagesLoaded !== true;
			};

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

			this.updateUnreadCount = function () {
				$.ajax({
					url: this.getBaseUrl() + '/notifications/unread-count',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.model.setUnreadCount(data.unreadCount);
				}));
			};

			this.markAsRead = function (id) {
				$.ajax({
					type: 'POST',
					data: JSON.stringify([id]),
					dataType: 'json',
					contentType: "application/json; charset=UTF-8",
					url: this.getBaseUrl() + '/notifications/mark-as-read/by-uri',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function () {
					this.model.markAsRead(id);
					this.updateUnreadCount();
				}));
			};

			this.markAllAsRead = function () {
				var since = this.model.getLatestEventTime();
				if (!since) {
					log('Marking as read did not find since ' + this.model, log.levels.info, common.logTag);
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
				}).done(this.proxy(function () {
					this.model.markAllAsRead();
				}));
			};

			this.loadFirstPage = function () {
				if (!this.shouldLoadFirstPage()) {
					return;
				}
				this.model.loadingStarted();
				$.ajax({
					url: this.getBaseUrl() + '/notifications',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.model.addNotifications(mapToModel(data.notifications));
					this.calculatePage(data);
				})).always(this.proxy(function () {
					this.model.loadingStopped();
				}));
			};

			this.loadMore = function () {
				if (!this.shouldLoadNextPage()) {
					return;
				}
				this.model.loadingStarted();
				$.ajax({
					url: this.getBaseUrl() + this.nextPage,
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.model.addNotifications(mapToModel(data.notifications));
					this.calculatePage(data);
				})).always(this.proxy(function () {
					this.model.loadingStopped();
				}));
			};

			this.calculatePage = function (data) {
				this.nextPage = getSafely(data, '_links.next');
				if (!this.nextPage) {
					this.allPagesLoaded = true;
				}
			};

			this.getBaseUrl = function () {
				return window.mw.config.get('wgOnSiteNotificationsApiUrl');
			};

			this.proxy = function (func) {
				//TODO replace proxy with .bind and remove jquery from dependencies
				return $.proxy(func, this);
			}
		}

		return Controller
	}
);
