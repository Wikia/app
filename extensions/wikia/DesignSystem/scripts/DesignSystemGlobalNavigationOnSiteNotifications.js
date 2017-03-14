require(
	['jquery', 'wikia.window', 'wikia.log',
		'ext.wikia.design-system.on-site-notifications.view',
		'ext.wikia.design-system.on-site-notifications.common'],
	function ($, window, log, View, common) {
		'use strict';

		/**
		 * Gets Date from ISO string date
		 * @param {string} date
		 * @returns {Date} - date
		 */
		function convertToTimestamp(date) {
			return new Date(date);
		}

		/**
		 * Gets ISO string from Date
		 * @param {Date} date
		 * @returns {string} - ISO string
		 */
		function convertToIsoString(date) {
			return date.toISOString();
		}

		function getSafely(obj, path) {
			return path.split(".").reduce(function (acc, key) {
				return (typeof acc == "undefined" || acc === null) ? acc : acc[key];
			}, obj);
		}

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
				var newNotifications = mapToModel(notifications);
				this.notifications = this.notifications.concat(newNotifications);
				if (this.notifications.length > 0) {
					this.view.renderNotifications(newNotifications);
				} else {
					this.view.renderZeroState();
				}
			};

			this.proxy = function (func) {
				return $.proxy(func, this);
			}
		}

		function Logic(model) {
			this.updateInProgress = false;
			this.model = model;

			this.startProgress = function () {
				this.updateInProgress = true;
			};

			this.stopProgress = function () {
				this.updateInProgress = false;
			};

			this.shouldLoadFirstPage = function () {
				return this.updateInProgress !== true && !this.nextPage && this.allPagesLoaded !== true;
			};

			this.shouldLoadNextPage = function () {
				return this.updateInProgress !== true && this.nextPage && this.allPagesLoaded !== true;
			};

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
				this.startProgress();
				$.ajax({
					url: this.getBaseUrl() + '/notifications',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.model.addNotifications(data.notifications);
					this.calculatePage(data);
				})).always(this.proxy(function () {
					this.stopProgress();
				}));
			};

			this.loadMore = function () {
				if (!this.shouldLoadNextPage()) {
					return;
				}
				this.startProgress();
				$.ajax({
					url: this.getBaseUrl() + this.nextPage,
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.model.addNotifications(data.notifications);
					this.calculatePage(data);
				})).always(this.proxy(function () {
					this.stopProgress();
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
				return $.proxy(func, this);
			}
		}

		var OnSiteNotifications = {
			init: function () {
				this.view = new View();
				this.model = new Model(this.view);
				this.logic = new Logic(this.model);

				this.view.registerEvents(this.logic);
				this.logic.updateUnreadCount();
			}
		};

		$(function () {
			OnSiteNotifications.init();
		});
	}
);
