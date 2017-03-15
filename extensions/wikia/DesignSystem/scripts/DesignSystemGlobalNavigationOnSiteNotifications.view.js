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

		var isVisibleClass = 'wds-is-visible',
			almostBottom = 100,
			avatarPlaceholder = 'http://static.wikia.nocookie.net/messaging/images/1/19/Avatar.jpg/revision/latest/scale-to-width-down/50',
			template = 'extensions/wikia/DesignSystem/services/templates/DesignSystemGlobalNavigationOnSiteNotifications.mustache';

		function View() {
			this.onDropDown = new Event(this);
			this.onLoadMore = new Event(this);
			this.onMarkAllAsRead = new Event(this);
			this.onMarkAsRead = new Event(this);

			this._spinner = new Spinner(14);
			this._textFormatter = new TextFormatter();
			this._$notificationsCount = $('#onSiteNotificationsCount');
			this._$container = $('#notificationContainer');
			this._$markAllAsReadButton = $('#markAllAsReadButton');

			this.registerEventHandlers = function (model) {
				this.addDropdownLoadingEvent();
				this.addMarkAllAsReadEvent();
				this.addOnScrollEvent();

				model.loadingStatusChanged.attach(function (_, isLoading) {
					if (isLoading === true) {
						this._$container.append(
							'<li class="loader">' + this._spinner.html + '</li>');
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
				if (this._hasAlmostScrolledToTheBottom($(e.target))) {
					this.onLoadMore.notify();
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
					this.onMarkAllAsRead.notify.bind(this.onMarkAllAsRead));
			};

			this.addDropdownLoadingEvent = function () {
				var $dropdown = $('#onSiteNotificationsDropdown');
				$dropdown.click(this.onDropDown.notify.bind(this.onDropDown));
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

				function ellipsis(text) {
					return text.length <= 30 ? text : text.substr(0, 30) + '&hellip;'
				}

				function mustacheEllipsis() {
					return function (text, render) {
						return render(ellipsis(text ? String(text).trim() : ''));
					}
				}

				return notifications.map(function (notification) {
					return {
						icon: getIcon(notification.type),
						uri: notification.uri,
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
						timeAgo: $.timeago(notification.when),
						ellipsis: mustacheEllipsis
					}
				}.bind(this));
			};

			this.renderNotifications = function (notifications) {
				templating.renderByLocation(template, this._mapToView(notifications))
					.then(function (html) {
						this._$container.append(html);
						this._bindMarkAsReadHandlers();
					}.bind(this));
			};

			this._bindMarkAsReadHandlers = function () {
				$(this._$container).find('.wds-notification-card__icon-wrapper')
					.click(this._markAsRead.bind(this));
			};

			this._markAsRead = function (e) {
				try {
					var id = $(e.target).closest('.wds-notification-card').attr('data-uri');
					this.onMarkAsRead.notify(id);
				} catch (e) {
					log('Failed to mark as read ' + e, log.levels.error, common.logTag);
				}
				return false;
			};

			this.renderZeroState = function () {
				$('.wds-notifications__zero-state').addClass(isVisibleClass);
			};

			this.renderUnreadCount = function (count) {
				if (count > 0) {
					this._$markAllAsReadButton.addClass(isVisibleClass);
					this._$notificationsCount.html(count).parent('.bubbles').addClass('show');
				} else {
					this._$markAllAsReadButton.removeClass(isVisibleClass);
					this._$notificationsCount.empty().parent('.bubbles').removeClass('show');
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
				findUnreadAndClearClass(this._$container);
			};

			this.renderNotificationAsRead = function (id) {
				var container = this._$container.find('[data-uri="' + id + '"]');
				findUnreadAndClearClass(container);
			};

		}

		return View
	}
);
