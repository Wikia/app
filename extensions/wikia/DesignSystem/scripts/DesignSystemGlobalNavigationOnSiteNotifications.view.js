define('ext.wikia.design-system.on-site-notifications.view', [
		'jquery',
		'wikia.log',
		'wikia.window',
		'ext.wikia.design-system.templating',
		'ext.wikia.design-system.loading-spinner',
		'ext.wikia.design-system.on-site-notifications.text-formatter',
		'ext.wikia.design-system.on-site-notifications.common'
	], function ($, log, window, templating, Spinner, TextFormatter, common) {
		'use strict';

		function View() {
			this.controller = null;
			this.spinner = new Spinner(14);
			this.textFormatter = new TextFormatter();
			this.$notificationsCount = $('#onSiteNotificationsCount');
			this.$container = $('#notificationContainer');
			this.$markAllAsReadButton = $('#markAllAsReadButton');

			var isVisibleClass = 'wds-is-visible',
				almostBottom = 100,
				avatarPlaceholder = 'http://static.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/50',
				template = 'extensions/wikia/DesignSystem/services/templates/DesignSystemGlobalNavigationOnSiteNotifications.mustache';

			this.registerEvents = function (controller, model) {
				this.controller = controller;
				this.addDropdownLoadingEvent();
				this.addMarkAllAsReadEvent();
				this.addOnScrollEvent();

				model.loadingStatusChanged.attach(function (_, isLoading) {
					if (isLoading === true) {
						this.$container.append(
							'<li class="loader">' + this.spinner.html + '</li>');
					} else {
						$('.loader').remove();
					}
				}.bind(this));

				model.notificationsAdded.attach(function (_, data) {
					if (data.total > 0) {
						this.renderNotifications(data.list);
					} else {
						this.renderZeroState();
					}
				}.bind(this));

				model.markedAllAsRead.attach(this.renderAllNotificationsAsRead.bind(this));
				model.markedAsRead.attach(function (_, uri) {
					this.renderNotificationAsRead(uri);
				}.bind(this));
				model.unreadCountChanged.attach(function (_, count) {
					this.renderUnreadCount(count);
				}.bind(this));
			};

			this.addOnScrollEvent = function () {
				var scrollableElement = $('.wds-notifications__notification-list');
				scrollableElement.on('scroll', this.onScroll.bind(this));
			};

			this.onScroll = function (e) {
				if (this.hasScrolledToTheBottom($(e.target))) {
					this.controller.loadMore();
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
				this.$markAllAsReadButton.click(this.controller.markAllAsRead.bind(this.controller));
			};

			this.addDropdownLoadingEvent = function () {
				var $dropdown = $('#onSiteNotificationsDropdown');
				$dropdown.click(this.controller.loadFirstPage.bind(this.controller));
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

				return notifications.map(function (notification) {
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
				}.bind(this));
			};

			this.renderNotifications = function (notifications) {
				templating.renderByLocation(template, this._mapToView(notifications))
					.then(function (html) {
						this.$container.append(html);
						this._bindMarkAsReadHandlers();
					}.bind(this));
			};

			this._bindMarkAsReadHandlers = function () {
				$(this.$container).find('.wds-notification-card__icon-wrapper')
					.click(this._markAsRead.bind(this));
			};

			this._markAsRead = function (e) {
				try {
					var id = $(e.target).closest('.wds-notification-card').attr('data-uri');
					this.controller.markAsRead(id);
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

		}

		return View
	}
);
