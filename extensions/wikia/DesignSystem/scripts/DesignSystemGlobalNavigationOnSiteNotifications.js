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
			},

			loadNotifications: function() {
				for (var i = 0; i < this.unreadCount; ++i) {
					var html = mustache.render(this.template, {'title': 'zorf' + i});
					this.$container.append(html);
				}
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
					setTimeout(this.proxy(this.loadNotifications), 300);
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
