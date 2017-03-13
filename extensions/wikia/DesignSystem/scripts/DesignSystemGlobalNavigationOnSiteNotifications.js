require(
	['jquery', 'wikia.window', 'wikia.loader', 'wikia.mustache', 'wikia.log'],
	function ($, window, loader, mustache, log) {
		'use strict';

		const notificationTypes = {
			discussionUpvotePost: 'discussion-upvote-post',
			discussionUpvoteReply: 'discussion-upvote-reply',
			discussionReply: 'discussion-reply',
			announcement: 'announcement'
		}, logTag = 'on-site-notifications';

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

		function TextFormatter() {
			function bold(text) {
				return text ? '<b>' + text + '</b>' : text;
			}

			function fillArgs(message, args) {
				return Object.keys(args).reduce(function (acc, key) {
					return acc.replace('__' + key + '__', args[key])
				}, message);
			}

			this.getText = function (notification) {
				if (notification.type === notificationTypes.discussionReply) {
					return this._getReplyText(notification);
				} else if (notification.type === notificationTypes.discussionUpvotePost) {
					return this._getPostUpvoteText(notification)
				} else if (notification.type === notificationTypes.discussionUpvoteReply) {
					return this._getReplyUpvoteText(notification);
				} else {
					return notification.title;
				}
			};

			this._getReplyText = function (notification) {
				const key = this._getReplyKey(notification.title, notification.totalUniqueActors);
				const message = window.mw.message(key).parse();
				var args = {
					postTitle: bold(notification.title)
				};

				if (notification.totalUniqueActors > 2) {
					args.mostRecentUser = notification.latestActors[0].name;
					args.number = notification.totalUniqueActors - 1;
				} else if (notification.totalUniqueActors == 2) {
					args.firstUser = notification.latestActors[0].name;
					args.secondUser = notification.latestActors[1].name;
				} else {
					args.user = notification.latestActors[0].name;
				}

				return fillArgs(message, args);
			};

			this._getReplyKey = function (title, totalUniqueActors) {
				const user = totalUniqueActors <= 1 ? '' :
					totalUniqueActors == 2 ? 'two-users-' : 'multiple-users-';
				return 'notifications-replied-by-' + user + (title ? 'with-title' : 'no-title');
			};

			this._getPostUpvoteText = function (notification) {
				const key = 'notifications-post-upvote' + this._getUpvoteKey(notification.title, notification.totalUniqueActors);
				const message = window.mw.message(key).parse();
				return fillArgs(message, {postTitle: bold(notification.title)});
			};

			this._getReplyUpvoteText = function (notification) {
				const key = 'notifications-reply-upvote' + this._getUpvoteKey(notification.title, notification.totalUniqueActors);
				const message = window.mw.message(key).parse();
				return fillArgs(message, {postTitle: bold(notification.title)});
			};

			this._getUpvoteKey = function (title, totalUniqueActors) {
				return '-' + (totalUniqueActors <= 1 ? 'single-user' : 'multiple-users')
					+ '-' + (title ? 'with-title' : 'no-title');
			};
		}

		function View(logic, template, textFormatter) {
			this.logic = logic;
			this.template = template;
			this.textFormatter = textFormatter;
			this.$notificationsCount = $('#on-site-notifications-count');
			this.$container = $('#notification-container');
			this.$markAllAsReadButton = $('#mark-all-as-read-button');

			this.registerEvents = function () {
				this.addDropdownLoadingEvent();
				this.addMarkAllAsReadEvent();
			};

			this.addMarkAllAsReadEvent = function () {
				this.$markAllAsReadButton.click($.proxy(this.logic.markAllAsRead, this.logic));
			};

			this.addDropdownLoadingEvent = function () {
				var $dropdown = $('#on-site-notifications-dropdown');
				$dropdown.click(function () {
					logic.loadFirstPage();
				});
			};

			this._mapToView = function (notifications) {
				function getIcon(type) {
					if (type === notificationTypes.discussionReply) {
						return 'wds-icons-reply-small';
					} else if (type === notificationTypes.announcement) {
						return 'wds-icons-megaphone';
					} else {
						return 'wds-icons-upvote-small';
					}
				}

				function getAvatars(actors) {
					return actors.slice(0, 5);
				}

				return notifications.map(this.proxy(function (notification) {
					return {
						icon: getIcon(notification.type),
						uri: notification.uri,
						snippet: notification.snippet,
						text: this.textFormatter.getText(notification),
						isUnread: notification.isUnread,
						communityName: notification.communityName,
						showAvatars: notification.totalUniqueActors > 2 && notification.type === notificationTypes.discussionReply,
						showAvatarOverflow: notification.totalUniqueActors > 5,
						avatarOverflow: notification.totalUniqueActors - 5,
						avatars: getAvatars(notification.latestActors),
						timeAgo: $.timeago(notification.when)
					}
				}));
			};

			this.renderNotifications = function (notifications) {
				var html = mustache.render(this.template, this._mapToView(notifications));
				this.$container.append(html);

				const markAsRead = this.proxy(function (e) {
					try {
						const id = $(e.target).closest('.wds-notification-card').attr('id');
						this.logic.markAsRead(id);
					} catch (e) {
						log('Failed to mark as read ' + e, log.levels.error, logTag);
					}
					return false;
				});

				$(this.$container).find('.wds-notification-card__icon-wrapper').click(markAsRead);
			};

			this.renderUnreadCount = function (count) {
				this.unreadCount = count;

				if (this.unreadCount > 0) {
					this.$markAllAsReadButton.addClass('wds-is-visible');
					this.$notificationsCount.html(this.unreadCount).parent('.bubbles').addClass('show');
				} else {
					this.$markAllAsReadButton.removeClass('wds-is-visible');
					this.$notificationsCount.empty().parent('.bubbles').removeClass('show');
				}
			};

			/**
			 * .classRemove does not work on SVG
			 * @param element
			 */
			function removeIsUnreadClass(element) {
				element.classList.remove('wds-is-unread');
			}

			function findUnreadAndClearClass($element) {
				$element.find('.wds-icon.wds-is-unread').each(function (_, e) {
					removeIsUnreadClass(e);
				});
			}

			this.renderAllNotificationsAsRead = function () {
				findUnreadAndClearClass(this.$container);
			};

			this.renderNotificationAsRead = function (id) {
				const container = this.$container.find('[id="' + id + '"]');
				findUnreadAndClearClass(container);
			};

			this.proxy = function (func) {
				return $.proxy(func, this);
			}
		}

		function Model(view) {
			this.view = view;
			this.notifications = [];
			this.unreadCount = 0;

			this.getLatestEventTime = function () {
				const latest = this.notifications[0];
				if (latest) {
					return latest.when;
				} else {
					return null;
				}
			};

			function getTypeFromApiData(notification) {
				if (notification.type === 'upvote-notification') {
					if (notification.refersTo.type === 'discussion-post') {
						return notificationTypes.discussionUpvoteReply;
					} else {
						return notificationTypes.discussionUpvotePost;
					}
				} else if (notification.type === 'replies-notification') {
					return notificationTypes.discussionReply;
				} else if (notification.type === 'announcement-notification') {
					return notificationTypes.announcement;
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
							//TODO profile URL
							// profileUrl: DiscussionContributor.getProfileUrl(data.name)
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
				this.notifications.forEach(setIsUnreadFalse);
				this.view.renderAllNotificationsAsRead();
			};

			this.setUnreadCount = function (count) {
				this.unreadCount = count;
				this.view.renderUnreadCount(count);
			};

			this.addNotifications = function (notifications) {
				this.notifications = this.notifications.concat(mapToModel(notifications));
				// TODO render only the new notifications
				this.view.renderNotifications(this.notifications);
			};
		}

		function Logic(bucky) {
			this.bucky = bucky;
			this.updateInProgress = false;
			this.model = null;

			this.shouldLoadFirstPage = function () {
				return this.updateInProgress !== true && !this.nextPage && this.allPagesLoaded !== true;
			};

			this.shouldLoadNextPage = function () {
				return this.updateInProgress !== true && !this.nextPage && this.allPagesLoaded !== true;
			};

			this.updateUnreadCount = function () {
				this.bucky.timer.start('updateCounts');
				$.ajax({
					url: this.getBaseUrl() + '/notifications/unread-count',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.model.setUnreadCount(data.unreadCount);
				})).always(this.proxy(function () {
					this.bucky.timer.stop('updateCounts');
				}));
			};

			this.markAsRead = function (id) {
				this.bucky.timer.start('markAsRead');
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
				})).always(this.proxy(function () {
					this.bucky.timer.stop('markAsRead');
				}));
			};

			this.markAllAsRead = function () {
				const since = this.model.getLatestEventTime();
				if (!since) {
					log('Marking as read did not find since ' + this.model, log.levels.info, logTag);
					return;
				}
				this.bucky.timer.start('markAllAsRead');
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
					this.model.setUnreadCount(0);
					this.model.markAllAsRead();
				})).always(this.proxy(function () {
					this.bucky.timer.stop('markAllAsRead');
				}));
			};

			this.loadFirstPage = function () {
				if (!this.shouldLoadFirstPage()) {
					return;
				}
				this.updateInProgress = true;
				this.bucky.timer.start('loadFirstPage');
				$.ajax({
					url: this.getBaseUrl() + '/notifications',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.model.addNotifications(data.notifications);
					this.calculatePage(data);
				})).always(this.proxy(function () {
					this.updateInProgress = false;
					this.bucky.timer.stop('loadFirstPage');
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
			init: function (template) {
				this.logic = new Logic(window.Bucky('OnSiteNotifications'));
				this.view = new View(this.logic, template, new TextFormatter());
				this.logic.model = new Model(this.view);

				this.view.registerEvents();
				setTimeout($.proxy(this.logic.updateUnreadCount, this.logic), 300);
			}
		};

		function compileMustache() {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/DesignSystem/services/templates/DesignSystemGlobalNavigationOnSiteNotifications.mustache',
				}
			}).done(function (assets) {
				OnSiteNotifications.init(assets.mustache[0]);
			});
		}

		$(function () {
			compileMustache();
		});
	}
);
