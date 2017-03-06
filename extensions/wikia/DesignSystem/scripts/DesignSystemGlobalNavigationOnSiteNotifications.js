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

				setTimeout(this.proxy(this.updateCounts), 300);

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

			loadFirstPage: function() {
				if (this.updateInProgress || this.nextPage) {
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
					this.bucky.timer.stop('loadFirstPage');
					this.nextPage = true;
					this.renderNotifications(this.mapToModel(data.notifications));
				})).fail(this.proxy(function() {
					this.bucky.timer.stop('loadFirstPage');
				}));
			},

			mapToModel: function(notifications) {
				return notifications;
			},

			renderNotifications: function(notifications) {
				notifications.forEach(this.proxy(function(notification){
					var html = mustache.render(this.template, { 'title': notification.refersTo.title });
					this.$container.append(html);
				}));
			},

			updateCounts: function () {
				this.bucky.timer.start('updateCounts');
				$.ajax({
					url: this.getBaseUrl() + '/notifications/unread-count',
					xhrFields: {
						withCredentials: true
					}
				}).done(this.proxy(function (data) {
					this.updateCountsHtml(data.unreadCount);
					this.bucky.timer.stop('updateCounts');
				})).fail(this.proxy(function () {
					this.bucky.timer.stop('updateCounts');
				}));
			},

			updateCountsHtml: function (count) {
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

			getBaseUrl: function() {
				return mw.config.get('wgOnSiteNotificationsApiUrl');
			}

		};

		function compileMustache() {
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/DesignSystem/services/templates/DesignSystemGlobalNavigationOnSiteNotifications.mustache',
					scripts: 'mustache_on_site_notifications_js'
				}
			}).done(function (assets) {
				loader.processScript(assets.scripts);
				OnSiteNotifications.init(assets.mustache[0]);
			});
		};

		$(function () {
			compileMustache();
		});
	}
);
