define('ext.wikia.design-system.on-site-notifications.view', [
		'jquery',
		'wikia.log',
		'wikia.window',
		'ext.wikia.design-system.event',
		'ext.wikia.design-system.templating',
		'ext.wikia.design-system.loading-spinner',
		'ext.wikia.design-system.on-site-notifications.text-formatter',
		'ext.wikia.design-system.on-site-notifications.common'
	], function ($, log, window, Event, templating, Spinner, TextFormatter, common) {
		'use strict';

		var isHiddenClass = 'wds-is-hidden',
			almostBottom = 100,
			avatarPlaceholder = 'https://vignette.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/50';

		function View() {
			this.onLoadMore = new Event(this);
			this.onDropDownClick = new Event(this);
			this.onMarkAllAsReadClick = new Event(this);
			this.onMarkAsReadClick = new Event(this);
			this.onNotificationClick = new Event(this);
			this.onNotificationRender = new Event(this);

			this._spinner = new Spinner(14);
			this._textFormatter = new TextFormatter();
			this._$notificationsCount = $('#onSiteNotificationsCount');
			this._$container = $('#notificationContainer');
			this._$markAllAsReadButton = $('#markAllAsReadButton');
			this._$scrollableElement = $('.wds-notifications__notification-list');

			this.registerEventHandlers = function (model) {
				this.addDropdownLoadingEvent();
				this.addMarkAllAsReadEvent();
				this.addOnScrollEvent();
				this.addOnMouseWheelEvent();

				model.loadingStatusChanged.attach(function (_, isLoading) {
					if (isLoading === true) {
						this._$container.append(
							'<li id="on-site-notifications-loader">' + this._spinner.html + '</li>');
					} else {
						$('#on-site-notifications-loader').remove();
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
				this._$scrollableElement.on('scroll', this.onScroll.bind(this));
			};

			this.addOnMouseWheelEvent = function () {
				this._$scrollableElement.on('mousewheel DOMMouseScroll', this.onMouseWheel);
			};

			this.onScroll = function (event) {
				if (this._hasAlmostScrolledToTheBottom($(event.target))) {
					this.onLoadMore.notify();
				}
			};

			this.onMouseWheel = function (event) {
				var delta = -event.originalEvent.wheelDelta || event.originalEvent.detail,
					scrollTop = this.scrollTop;
				if ((delta < 0 && scrollTop === 0)
					|| (delta > 0 && this.scrollHeight - this.clientHeight - scrollTop === 0)) {
					event.preventDefault();
				}
			};

			/**
			 * Has the user scrolled almost to the bottom?
			 * @private
			 */
			this._hasAlmostScrolledToTheBottom = function (element) {
				return element[0].scrollHeight - almostBottom
					<= element.scrollTop() + element.innerHeight();
			};

			this.addMarkAllAsReadEvent = function () {
				this._$markAllAsReadButton.click(
					this.onMarkAllAsReadClick.notify.bind(this.onMarkAllAsReadClick));
			};

			this.addDropdownLoadingEvent = function () {
				$('#onSiteNotificationsDropdown').on('mouseenter',
					this.onDropDownClick.notify.bind(this.onDropDownClick)
				);
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
						type: notification.type,
						uri: notification.uri,
						latestEventUri: notification.latestEventUri,
						showSnippet: !notification.title,
						snippet: notification.snippet,
						text: this._textFormatter.getText(notification),
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
				var html = templating.renderNotifications(this._mapToView(notifications));
				this._$container.append(html);
				this._bindMarkAsReadHandlers();
				this._bindNotificationClickedHandlers();
				this._notifyRendered(notifications);
			};

			this._notifyRendered = function (notifications) {
				notifications.forEach(function (notification) {
					this.onNotificationRender.notify({
						uri: notification.uri,
						type: notification.type
					});
				}.bind(this));
			};

			this._bindMarkAsReadHandlers = function () {
				$(this._$container).find('.wds-notification-card__icon-wrapper')
					.click(this._markAsRead.bind(this));
			};

			this._bindNotificationClickedHandlers = function () {
				$(this._$container).find('.wds-notification-card__outer-body')
					.click(this._clickNotification.bind(this));
			};

			this._clickNotification = function (e) {
				this.onNotificationClick.notify(this._findId(e));
			};

			this._findId = function (e) {
				try {
					var $element = $(e.target).closest('.wds-notification-card');
					return {
						uri: $element.attr('data-uri'),
						type: $element.attr('data-type')
					};
				} catch (e) {
					log('Failed to find uri ' + e, log.levels.error, common.logTag);
				}
			};

			this._markAsRead = function (e) {
				this.onMarkAsReadClick.notify(this._findId(e));
				return false;
			};

			this.renderZeroState = function () {
				$('.wds-notifications__zero-state').removeClass(isHiddenClass);
			};

			this.renderUnreadCount = function (count) {
				if (count > 0) {
					this._$markAllAsReadButton.removeClass(isHiddenClass);
					this._$notificationsCount.html(limitTo99(count))
						.removeClass(isHiddenClass);
				} else {
					this._$markAllAsReadButton.addClass(isHiddenClass);
					this._$notificationsCount.empty()
						.addClass(isHiddenClass);
				}
			};

			function limitTo99(count) {
				if (count > 99) {
					return '99+';
				} else {
					return count;
				}
			}

			function removeIsUnreadClass(element) {
				element.removeClass('wds-is-unread');
			}

			function findUnreadAndClearClass($element) {
				$element.find('.wds-notification-card.wds-is-unread').each(function (_, element) {
					removeIsUnreadClass(element);
				});
			}

			this.renderAllNotificationsAsRead = function () {
				findUnreadAndClearClass(this._$container);
			};

			this.renderNotificationAsRead = function (id) {
				var element = this._$container.find('[data-uri="' + id + '"]');
				removeIsUnreadClass(element);
			};

		}

		return View
	}
);
