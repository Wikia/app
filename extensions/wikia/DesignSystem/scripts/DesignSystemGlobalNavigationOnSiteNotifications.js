require(
	['jquery', 'wikia.window', 'wikia.mustache'],
	function ($, window, mustache) {
		'use strict';

		var OnSiteNotifications = {
			init: function () {
				this.bucky = window.Bucky('OnSiteNotifications');

				// we only want 1 update simultaneously
				this.updateInProgress = false;

				setTimeout(this.proxy(this.updateCounts), 300);

				this.$window = $(window);
				this.$notificationsCount = $('.on-site-notifications-count');
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
				return 'https://services.wikia-dev.pl/on-site-notifications';
				// return mw.config.get('wgOnSiteNotificationsApiUrl');
			}

		};

		$(function () {
			OnSiteNotifications.init();
		});
	}
);
