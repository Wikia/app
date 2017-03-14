define('ext.wikia.design-system.on-site-notifications.view',
	['jquery', 'wikia.window',
		'ext.wikia.design-system.templating',
		'ext.wikia.design-system.loading-spinner',
		'ext.wikia.design-system.on-site-notifications.text-formatter',
		'ext.wikia.design-system.on-site-notifications.common'],
	function ($, window, templating, Spinner, TextFormatter, common) {
		'use strict';

		function View() {
			this.logic = null;
			this.spinner = new Spinner(14);
			this.textFormatter = new TextFormatter();
			this.$notificationsCount = $('#onSiteNotificationsCount');
			this.$container = $('#notificationContainer');
			this.$markAllAsReadButton = $('#markAllAsReadButton');

			var isVisibleClass = 'wds-is-visible',
				almostBottom = 100,
				avatarPlaceholder = 'http://static.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/50',
				template = 'extensions/wikia/DesignSystem/services/templates/DesignSystemGlobalNavigationOnSiteNotifications.mustache';

			this.registerEvents = function (logic) {
				this.logic = logic;
				this.addDropdownLoadingEvent();
				this.addMarkAllAsReadEvent();
				this.addOnScrollEvent();
			};

			this.addOnScrollEvent = function () {
				var scrollableElement = $('.wds-notifications__notification-list');
				scrollableElement.on('scroll', this.proxy(this.onScroll));
			};

			this.onScroll = function (e) {
				if (this.hasScrolledToTheBottom($(e.target))) {
					this.logic.loadMore();
				}
			};

			/**
			 * Has the user  scrolled almost to the bottom?
			 * @private
			 */
			this.hasScrolledToTheBottom = function (element) {
				return element[0].scrollHeight - almostBottom <= element.scrollTop() + element.innerHeight();
			};

			this.addMarkAllAsReadEvent = function () {
				this.$markAllAsReadButton.click($.proxy(this.logic.markAllAsRead, this.logic));
			};

			this.addDropdownLoadingEvent = function () {
				var $dropdown = $('#onSiteNotificationsDropdown');
				$dropdown.click(this.proxy(function () {
					this.logic.loadFirstPage();
				}));
			};

			this._mapToView = function (notifications) {
				function getIcon(type) {
					if (type === common.notificationTypes.discussionReply) {
						return 'wds-icons-reply-small';
					} else if (type === common.notificationTypes.announcement) {
						return 'wds-icons-megaphone';
					} else {
						return 'wds-icons-upvote-small';
					}
				}

				function getAvatars(actors) {
					return actors.slice(0, 5).map(function (avatar) {
						if (!avatar.avatarUrl) {
							avatar.avatarUrl = avatarPlaceholder;
						}
						avatar.profileUrl = '/wiki/User:' + avatar.name;
						return avatar;
					});
				}

				return notifications.map(this.proxy(function (notification) {
					return {
						icon: getIcon(notification.type),
						uri: notification.uri,
						showSnippet: !notification.title,
						snippet: notification.snippet,
						text: this.textFormatter.getText(notification),
						isUnread: notification.isUnread,
						communityName: notification.communityName,
						showAvatars: notification.totalUniqueActors > 2
						&& notification.type === common.notificationTypes.discussionReply,
						showAvatarOverflow: notification.totalUniqueActors > 5,
						avatarOverflow: notification.totalUniqueActors - 5,
						avatars: getAvatars(notification.latestActors),
						timeAgo: $.timeago(notification.when)
					}
				}));
			};

			this.renderNotifications = function (notifications) {
				templating.renderByLocation(template, this._mapToView(notifications))
					.then(this.proxy(function (html) {
						this.$container.append(html);
						this._bindMarkAsReadHandlers();
					}));
			};

			this._bindMarkAsReadHandlers = function () {
				$(this.$container).find('.wds-notification-card__icon-wrapper')
					.click(this.proxy(this._markAsRead));
			};

			this._markAsRead = function (e) {
				try {
					var id = $(e.target).closest('.wds-notification-card').attr('data-uri');
					this.logic.markAsRead(id);
				} catch (e) {
					log('Failed to mark as read ' + e, log.levels.error, common.logTag);
				}
				return false;
			};

			this.renderZeroState = function () {
				$('.wds-notifications__zero-state').addClass(isVisibleClass);
			};

			this.renderUnreadCount = function (count) {
				this.unreadCount = count;

				if (this.unreadCount > 0) {
					this.$markAllAsReadButton.addClass(isVisibleClass);
					this.$notificationsCount.html(this.unreadCount).parent('.bubbles').addClass('show');
				} else {
					this.$markAllAsReadButton.removeClass(isVisibleClass);
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
				$element.find('.wds-icon.wds-is-unread').each(function (_, element) {
					removeIsUnreadClass(element);
				});
			}

			this.renderAllNotificationsAsRead = function () {
				findUnreadAndClearClass(this.$container);
			};

			this.renderNotificationAsRead = function (id) {
				var container = this.$container.find('[data-uri="' + id + '"]');
				findUnreadAndClearClass(container);
			};

			this.proxy = function (func) {
				return $.proxy(func, this);
			}
		}

		return View
	}
);
