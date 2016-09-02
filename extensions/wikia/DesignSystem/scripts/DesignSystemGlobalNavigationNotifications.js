require(
	['jquery', 'wikia.window', 'wikia.nirvana'],
	function($, window, nirvana) {
		'use strict';

		var WallNotifications = {
			init: function () {
				this.bucky = window.Bucky('WallNotifications');

				// we only want 1 update simultaneously
				this.updateInProgress = false;

				// HTML for "trays" for different Wiki ids
				this.notificationsCache = {};

				// all open "trays" (Wiki Notifications) - list of Wiki ids
				this.wikiShown = {};

				// we only want to force-fetch notifications for current Wiki once
				this.fetchedCurrent = false;

				// updated after fetching Notification counts for the 1st time
				this.currentWikiId = 0;

				this.cityId = parseInt(window.wgCityId, 10);

				setTimeout(this.proxy(this.updateCounts), 300);

				this.$window = $(window);
				this.$notificationsCount = $('.notifications-count');
				this.$notifications = $('#notifications');
				this.$notificationsEntryPoint = $('#notificationsEntryPoint');
				this.$wallNotifications = $('#GlobalNavigationWallNotifications');
				this.$notificationsContainer = $('#notificationsContainer');
				this.$notificationsMessages = $('> ul', this.$notificationsContainer);

				this.globalNavigationHeight = $('#globalNavigation').outerHeight();
				this.notificationsMarkAsReadHeight = 0;
				this.notificationsHeaderHeight = 0;
				this.notificationsBottomPadding = 20;

				this.unreadCount = parseInt(this.$notificationsCount.html(), 10);

				this.$notificationsEntryPoint
					.on('click', this.proxy(this.updateCounts))
					.on('click', this.proxy(this.fetchForCurrentWiki))
					.on('wds-dropdown-open', this.proxy(this.onNotificationsOpen));

				this.$wallNotifications.add($('#pt-wall-notifications'))
					.on('click', '.notifications-markasread', this.markAllAsReadAllWikis.bind(this));


				$(window).on('resize', $.throttle(50, function () {
					WallNotifications.setNotificationsHeight();
				}));
			},

			checkIfFromMessageBubble: function () {
				function urlParam(name) {
					var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
					if (!results) {
						return 0;
					}
					return results[1] || 0;
				}

				if (urlParam('showNotifications')) {
					this.$notifications.trigger('mouseenter');
					this.$wallNotifications.addClass('show');
				}
			},

			updateCounts: function () {
				this.bucky.timer.start('updateCounts');
				var data,
					callback = this.proxy(function (data) {
						if (data.status !== true || data.html === '') {
							return;
						}

						if (data.count) {
							this.$notifications.removeClass('prehide');
						}

						this.updateCountsHtml(data);

						// if we already have data for some Wikis, show it
						this.restoreFromCache();

						// make sure at least 1 element is visible
						this.showFirst();

						// on first updateCounts show notifications if user
						// came from Notification bubble on non-wall Wiki
						this.checkIfFromMessageBubble();

						// do not update for next 10s
						setTimeout(this.proxy(function () {
							this.updateInProgress = false;
						}), 10000);

						this.bucky.timer.stop('updateCounts');
					});


				if (this.updateInProgress === false) {
					this.updateInProgress = true;

					data = this.getUrlParams();

					nirvana.sendRequest({
						controller: 'WallNotificationsExternalController',
						method: 'getUpdateCounts',
						format: 'json',
						type: 'GET',
						data: data,
						callback: callback
					});
				}
			},

			fetchForCurrentWiki: function () {
				this.bucky.timer.start('fetchForCurrentWiki');
				if (this.fetchedCurrent === false) {
					var wikiEl = this.$wallNotifications.find('.notifications-for-wiki').first(),
						firstWikiId = parseInt(wikiEl.data('wiki-id'), 10);

					if ( !isNaN(firstWikiId) ) {
						wikiEl.addClass('show');
						this.fetchedCurrent = true;
						this.currentWikiId = firstWikiId;
						this.wikiShown[firstWikiId] = true;
						this.updateWiki(firstWikiId);
						this.bucky.timer.stop('fetchForCurrentWiki');
					}
				}
			},

			restoreFromCache: function () {
				// after updating counts we update DOM, so all notifications are empty
				// we update them from cache for all those that still have the same
				// amount of unread notifications and fetch all the others
				for (var wikiId in this.notificationsCache) {
					if (this.notificationsCache.hasOwnProperty(wikiId)) {
						this.updateWiki(parseInt(wikiId, 10));
					}
				}
			},

			markAllAsReadRequest: function (forceAll) {
				this.bucky.timer.start('markAllAsReadRequest');
				nirvana.sendRequest({
					controller: 'WallNotificationsExternalController',
					method: 'markAllAsRead',
					format: 'json',
					data: {
						forceAll: forceAll
					},
					callback: this.proxy(function (data) {
						if (data.status !== true) {
							return;
						}

						this.updateCountsHtml(data);

						// if we already have data for some Wikis, show it
						this.restoreFromCache();

						// make sure user doesn't trap himself
						// (closed tray for current wiki, marks all as read
						//	= tray is hidden (because there are no other wikis with notifications)
						//  = no ability to show notifications, no tray)
						this.showFirst();

						this.bucky.timer.stop('markAllAsReadRequest');
					})
				});
			},

			markAllAsReadAllWikis: function () {
				this.markAllAsReadRequest('FORCE');
				return false;
			},

			showFirst: function () {
				var wikiEl = this.$wallNotifications.find('.notifications-for-wiki').first(),
					firstWikiId = parseInt(wikiEl.data('wiki-id'), 10);

				if ( !isNaN(firstWikiId) ) {
					wikiEl.addClass('show');
					this.wikiShown = {};
					this.wikiShown[firstWikiId] = true;
				}
			},

			updateCountsHtml: function (data) {
				this.$wallNotifications.html(data.html);
				this.unreadCount = data.count;

				if (data.count > 0) {
					this.$notificationsCount.html(data.count).parent('.bubbles').addClass('show');
					this.fetchForCurrentWiki();
					this.$wallNotifications.addClass('show');
				} else {
					this.$notificationsCount.empty().parent('.bubbles').removeClass('show');
				}

				this.$wallNotifications.find('.notifications-wiki-header').click(this.wikiClick.bind(this));

				this.setNotificationsHeight();
			},

			wikiClick: function (e) {
				var wikiEl = $(e.target).closest('.notifications-for-wiki'),
					wikiId = parseInt(wikiEl.data('wiki-id'), 10);

				if (wikiEl.hasClass('show')) {
					wikiEl.removeClass('show');
					delete this.wikiShown[wikiId];
					this.setNotificationsHeight();
				} else {
					wikiEl.addClass('show');
					this.wikiShown[wikiId] = true;
					this.updateWiki(wikiId);
				}

				return false;
			},

			updateWiki: function (wikiId) {
				if (!(wikiId in this.notificationsCache)) {
					// nothing in cache, just fetch
					this.updateWikiFetch(wikiId);
					return;
				}
				var data = this.notificationsCache[wikiId],
					wikiCount = parseInt(this.$wallNotifications.find(
						'li[data-wiki-id=' + wikiId + ']'
					).data('unread-count'), 10);
				// no change in notifications, update from cache
				if (wikiCount === data['unread']) {
					this.updateWikiHtml(wikiId, data);

					// different number of unread, fetch from server
					// in the meantime, show old data
				} else {
					this.updateWikiHtml(wikiId, data);
					this.updateWikiFetch(wikiId);
				}
			},

			updateWikiFetch: function (wikiId) {
				var isCrossWiki = (wikiId === this.cityId) ? '0' : '1',
					data = {
						wikiId: wikiId,
						isCrossWiki: isCrossWiki
					};

				$.extend(data, this.getUrlParams());

				nirvana.sendRequest({
					controller: 'WallNotificationsExternalController',
					method: 'getUpdateWiki',
					type: 'GET',
					data: data,
					callback: this.proxy(function (data) {
						if (data.status !== true || data.html === '') {
							return;
						}
						this.updateWikiHtml(wikiId, data);
						this.notificationsCache[wikiId] = data;
					}),
					onErrorCallback: this.proxy(function (jqXHR) {
						if (jqXHR !== undefined && jqXHR.status !== undefined && jqXHR.status === 501) {
							var data = {};
							data.html = '<li class="notifications-empty">' + $.msg('wall-notifications-wall-disabled') + '</li>';
							this.updateWikiHtml(wikiId, data);
							this.notificationsCache[wikiId] = data;
						}
					})
				});
			},

			updateWikiHtml: function (wikiId, data) {
				var wikiEl = this.$wallNotifications.find('li[data-wiki-id=' + wikiId + ']'),
					wikiLi = wikiEl.find('.notifications-for-wiki-list');

				wikiLi.html(data.html);

				if (this.wikiShown[wikiId]) {
					wikiEl.addClass('show');
				}

				wikiLi.find('time').timeago();

				// hijack links for other wikis - open them in new window
				if (wikiId !== this.currentWikiId) {
					wikiEl.find('a').attr('target', '_blank');

					// temporary fix, should be changed on server side
					wikiEl.find('.read').remove();
				}

				this.setNotificationsHeight();
			},

			getLastSeenCount: function () {
				return $.cookies.get('WallUnreadCount') || 0;
			},

			setLastSeenCount: function (val) {
				$.cookies.set('WallUnreadCount', val);
			},

			proxy: function (func) {
				return $.proxy(func, this);
			},

			getUrlParams: function () {
				var data = {},
					qs = Wikia.Querystring(),
					lang, skin;

				skin = qs.getVal('useskin');
				if (skin) {
					data.useskin = skin;
				}

				lang = qs.getVal('uselang');
				if (lang) {
					data.uselang = lang;
				}

				return data;
			},

			setNotificationsHeight: function () {
				var isDropdownOpen = this.$wallNotifications.hasClass('show'),
					height,
					msgHeight;

				if (isDropdownOpen) {

					if (this.notificationsMarkAsReadHeight === 0) {
						this.notificationsMarkAsReadHeight = $('.notifications-markasread').outerHeight();
					}

					height = this.$window.height() - this.globalNavigationHeight - this.notificationsBottomPadding - this.notificationsMarkAsReadHeight;
					msgHeight = this.$notificationsMessages.height();

					if (!msgHeight) {
						this.$notificationsContainer = $('#notificationsContainer');
						this.$notificationsMessages = $('> ul', this.$notificationsContainer);
						msgHeight = this.$notificationsMessages.height();
					}

					if (this.notificationsHeaderHeight <= 0) {
						this.notificationsHeaderHeight = $('.notifications-header', this.$wallNotifications).outerHeight();
					}

					if (height < msgHeight + this.notificationsHeaderHeight) {
						this.$notificationsContainer
							.css('height', height - this.notificationsHeaderHeight)
							.addClass('scrollable');
					} else {
						this.$notificationsContainer.css('height', 'auto').removeClass('scrollable');
					}
				}
			},

			onNotificationsOpen: function () {
				WallNotifications.$wallNotifications.addClass('show');
				WallNotifications.setNotificationsHeight();
			}
		};

		$(function () {
			WallNotifications.init();
		});
	}
);
