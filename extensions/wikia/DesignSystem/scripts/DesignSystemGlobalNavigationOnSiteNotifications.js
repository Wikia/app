require(
	['jquery', 'wikia.window', 'wikia.loader', 'wikia.mustache'],
	function ($, window, loader, mustache) {
		'use strict';

		var OnSiteNotifications = {
			init: function (template) {
				this.template = template;
				this.bucky = window.Bucky('OnSiteNotifications');

				// we only want 1 update simultaneously
				this.updateInProgress = false;

				setTimeout(this.proxy(this.updateUnreadCount), 300);

				this.$window = $(window);
				this.$notificationsCount = $('.on-site-notifications-count');
				this.$container = $('#on-site-notifications');

				this.addDropdownLoadingEvent();
			},

			addDropdownLoadingEvent: function () {
				var $dropdown = $('#on-site-notifications-dropdown');
				$dropdown.click(function () {
					OnSiteNotifications.loadFirstPage();
				});
			},

			shouldLoadFirstPage: function () {
				return !this.updateInProgress && this.nextPage && this.allPagesLoaded !== true;
			},

			shouldLoadNextPage: function () {
				return !this.updateInProgress && !this.nextPage && this.allPagesLoaded !== true;
			},

			loadFirstPage: function () {
				if (this.shouldLoadFirstPage()) {
					return;
				}
				this.updateInProgress = true;
				this.bucky.timer.start('loadFirstPage');
				$.ajax({
					url: this.getBaseUrl() + '/notifications',
					xhrFields: {
						withCredentials: true
					},
					dataType: 'json'
				}).done(this.proxy(function (data) {
					this.renderNotifications(this.mapToModel(data.notifications));
					this.calculatePage(data);
				})).always(this.proxy(function () {
					this.updateInProgress = false;
					this.bucky.timer.stop('loadFirstPage');
				}));
			},

			calculatePage: function (data) {
				this.nextPage = getSafely(data, '_links.next');
				if (!this.nextPage) {
					this.allPagesLoaded = true;
				}
			},

			mapToModel: function (notifications) {
				return notifications.map(function (notification) {
					return {
						title: getSafely(notification, 'refersTo.title'),
						snippet: getSafely(notification, 'refersTo.snippet'),
						uri: getSafely(notification, 'refersTo.uri'),
						timestamp: getSafely(notification, 'events.latestEvent.when'),
						communityName: getSafely(notification, 'community.name'),
						communityId: getSafely(notification, 'community.id'),
						isUnread: notification.read === false,
						totalUniqueActors: getSafely(notification, 'events.totalUniqueActors')
						// latestActors: NotificationModel.createActors(x.events.latestActors')),
						// type: NotificationModel.getTypeFromApiData(notificationData)
					};
				});
			},

			renderNotifications: function (notifications) {
				notifications.forEach(this.proxy(function (notification) {
					var html = mustache.render(this.template, notification);
					this.$container.append(html);
				}));
			},

			updateUnreadCount: function () {
				this.bucky.timer.start('updateCounts');
				$.ajax({
					url: this.getBaseUrl() + '/notifications/unread-count',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.updateUnreadCountHtml(data.unreadCount);
				})).always(this.proxy(function () {
					this.bucky.timer.stop('updateCounts');
				}));
			},

			updateUnreadCountHtml: function (count) {
				this.unreadCount = count;

				if (this.unreadCount > 0) {
					this.$notificationsCount.html(this.unreadCount).parent('.bubbles').addClass('show');
				} else {
					this.$notificationsCount.empty().parent('.bubbles').removeClass('show');
				}
			},

			proxy: function (func) {
				return $.proxy(func, this);
			},

			getBaseUrl: function () {
				return mw.config.get('wgOnSiteNotificationsApiUrl');
			}

		};

		function compileMustache() {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/DesignSystem/services/templates/DesignSystemGlobalNavigationOnSiteNotifications.mustache',
					scripts: 'design_system_on_site_notifications_mustache_js'
				}
			}).done(function (assets) {
				loader.processScript(assets.scripts);
				OnSiteNotifications.init(assets.mustache[0]);
			});
		}

		function getSafely(obj, path) {
			return path.split(".").reduce(function (acc, key) {
				return (typeof acc == "undefined" || acc === null) ? acc : acc[key];
			}, obj);
		}

		$(function () {
			compileMustache();
		});
	}
);
