require(
	['jquery', 'wikia.window', 'wikia.nirvana'],
	function($, window, nirvana) {
		'use strict';

		var WallNotifications = {
			init: function() {
				this.wikisUrls = {};
				this.updateInProgress = false; // we only want 1 update simultaneously
				this.notificationsCache = {}; // HTML for "trays" for different Wiki ids
				this.wikiShown = {}; // all open "trays" (Wiki Notifications) - list of Wiki ids
				this.fetchedCurrent = false; // we only want to force-fetch notifications for current Wiki once
				this.currentWikiId = 0; // updated after fetching Notification counts for the 1st time
				this.cityId = parseInt(window.wgCityId, 10);

				setTimeout( this.proxy( this.updateCounts ), 300);

				this.$window = $(window);

				this.$notificationsCount = $('.notifications-count');

				this.$notifications = $('#notifications');
				this.$wallNotifications = $('#GlobalNavigationWallNotifications');

				this.unreadCount = parseInt(this.$notificationsCount.html(), 10);

				this.$notifications
					.mouseenter( this.proxy( this.updateCounts ) )
					.mouseenter( this.proxy( this.fetchForCurrentWiki ) );

				this.$wallNotifications.add( $('#pt-wall-notifications') )
					.on('click', '#markasread-sub', this.proxy( this.markAllAsReadPrompt ))
					.on('click', '#markasread-this-wiki', this.proxy( this.markAllAsRead ))
					.on('click', '#markasread-all-wikis', this.proxy( this.markAllAsReadAllWikis ));
			},

			openNotifications: function(row) {
				if ( row.getAttribute('id') === 'notifications' ) {
					$('#GlobalNavigationWallNotifications').addClass('show');
				}
			},

			closeNotifications: function() {
				$('#GlobalNavigationWallNotifications').removeClass('show');
			},

			checkIfFromMessageBubble: function() {
				function urlParam(name){
					var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
					if (!results){
						return 0;
					}
					return results[1] || 0;
				}
				if(urlParam('showNotifications')) {
					this.$notifications.trigger('mouseenter');
					this.$wallNotifications.addClass('show');
				}
			},

			updateCounts: function() {
				var callback = this.proxy(function(data) {
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
					setTimeout( this.proxy(function() {
						this.updateInProgress = false;
					}), 10000 );
				});



				if ( this.updateInProgress ===  false ) {
					this.updateInProgress = true;

					nirvana.sendRequest({
						controller: 'WallNotificationsExternalController',
						method: 'getUpdateCounts',
						format: 'json',
						callback: callback
					});
				}
			},

			fetchForCurrentWiki: function() {
				if ( this.fetchedCurrent === false ) {
					var wikiEl = this.$wallNotifications.find('.notifications-for-wiki').first(),
						firstWikiId = parseInt(wikiEl.data('wiki-id'), 10);

					if ( firstWikiId !== undefined ) {
						wikiEl.addClass('show');
						this.fetchedCurrent = true;
						this.currentWikiId = firstWikiId;
						this.wikiShown[ firstWikiId ] = true;
						this.updateWiki( firstWikiId );
					}
				}
			},

			restoreFromCache: function() {
				// after updating counts we update DOM, so all notifications are empty
				// we update them from cache for all those that still have the same
				// amount of unread notifications and fetch all the others
				for (var wikiId in this.notificationsCache) {
					this.updateWiki( parseInt(wikiId, 10) );
				}
			},

			markAllAsReadRequest: function(forceAll) {
				nirvana.sendRequest({
					controller: 'WallNotificationsExternalController',
					method: 'markAllAsRead',
					format: 'json',
					data: {
						username: window.wgTitle,
						forceAll: forceAll
					},
					callback: this.proxy(function(data) {
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
					})
				});
			},

			markAllAsReadPrompt: function(e) {
				$(e.target).parent().addClass('show');
			},

			markAllAsRead: function(e) {
				e.preventDefault();
				this.markAllAsReadRequest( false );
				return false;
			},

			markAllAsReadAllWikis: function(e) {
				e.preventDefault();
				this.markAllAsReadRequest( 'FORCE' );
				return false;
			},

			showFirst: function() {
				var wikiEl = this.$wallNotifications.find('.notifications-for-wiki').first(),
					firstWikiId = parseInt(wikiEl.data('wiki-id'), 10);

				if ( firstWikiId !== undefined ) {
					wikiEl.addClass('show');
					this.wikiShown = {};
					this.wikiShown[ firstWikiId ] = true;
				}
			},

			updateCountsHtml: function(data) {
				var self = this,
					element;

				this.$wallNotifications.html(data.html);
				this.unreadCount = data.count;

				if (data.count > 0) {
					this.$notificationsCount.html(data.count).parent('.bubbles').addClass('show');
				} else {
					this.$notificationsCount.empty().parent('.bubbles').removeClass('show');
				}

				this.$wallNotifications.find('.notifications-for-wiki').each(function() {
					element = $(this);
					self.wikisUrls[ parseInt(element.data('wiki-id'), 10) ] = self.getWikiUrl( element.data('wiki-path') );
				});

				this.$wallNotifications.find('.notifications-wiki-header').click( this.proxy( this.wikiClick ) );
			},

			wikiClick: function(e) {
				e.preventDefault();
				var wikiEl = $(e.target).closest('.notifications-for-wiki'),
					wikiId = parseInt(wikiEl.data('wiki-id'), 10);

				if( wikiEl.hasClass('show') ) {
					wikiEl.removeClass('show');
					delete this.wikiShown[ wikiId ];
				} else {
					wikiEl.addClass('show');
					this.wikiShown[ wikiId ] = true;
					this.updateWiki(wikiId);
				}
				return false;
			},

			updateWiki: function(wikiId) {
				if( !(wikiId in this.notificationsCache) ) {
					// nothing in cache, just fetch
					this.updateWikiFetch( wikiId );
					return;
				}
				var data = this.notificationsCache[ wikiId ],
					wikiCount = parseInt( this.$wallNotifications.find(
						'li[data-wiki-id=' + wikiId + ']'
					).data('unread-count'), 10);
				// no change in notifications, update from cache
				if ( wikiCount === data[ 'unread' ] ) {
					this.updateWikiHtml( wikiId, data );

				// different number of unread, fetch from server
				// in the meantime, show old data
				} else {
					this.updateWikiHtml( wikiId, data );
					this.updateWikiFetch( wikiId );
				}
			},

			updateWikiFetch: function(wikiId) {
				var isCrossWiki = (wikiId === this.cityId) ? '0' : '1';
				nirvana.sendRequest({
					controller: 'WallNotificationsExternalController',
					method: 'getUpdateWiki',
					format: 'jsonp',
					scriptPath: this.wikisUrls[wikiId],
					data: {
						username: window.wgTitle,
						wikiId: wikiId,
						isCrossWiki: isCrossWiki
					},
					callback: this.proxy(function(data) {
						if(data.status !== true || data.html === '') { return; }
						this.updateWikiHtml(wikiId, data);
						this.notificationsCache[ wikiId ] = data;
					}),
					onErrorCallback: this.proxy(function(jqXHR, textStatus, errorThrown) {
						if( jqXHR !== undefined && jqXHR.status !== undefined && jqXHR.status === 501) {
							var data = {};
							data.html = '<li class="notifications-empty">' + $.msg('wall-notifications-wall-disabled') + '</li>';
							this.updateWikiHtml(wikiId, data);
							this.notificationsCache[ wikiId ] = data;
						}
					})
				});
			},

			updateWikiHtml: function( wikiId, data ) {
				var wikiEl = this.$wallNotifications.find('li[data-wiki-id=' + wikiId + ']'),
					wikiLi = wikiEl.find('.notifications-for-wiki-list');

				wikiLi.html(data.html);

				if ( this.wikiShown[ wikiId ] ) {
					wikiEl.addClass('show');
				}

				wikiLi.find('time').timeago();

				// hijack links for other wikis - open them in new window
				if ( wikiId !== this.currentWikiId ) {
					wikiEl.find('a').attr('target', '_blank');

					// temporary fix, should be changed on server side
					wikiEl.find('.read').remove();
				}
			},

			getLastSeenCount: function() {
				return $.cookies.get( 'WallUnreadCount' ) || 0;
			},

			setLastSeenCount: function( val ) {
				$.cookies.set( 'WallUnreadCount', val );
			},

			proxy: function( func ) {
				return $.proxy( func, this );
			},

			getWikiUrl: function( url ) {
				if ( window.wgStagingEnvironment && url ) {
					var stagingEnv = window.location.hostname.split( '.' )[0];
					if ( url.indexOf( stagingEnv ) === -1 ) {
						url = url.replace( '://', '://' + stagingEnv + '.' );
					}
				}
				return url;
			}
		};

		$(function () {
			WallNotifications.init();

			window.menuAim(
				document.querySelector('.user-menu'), {
					activeRow: '#notifications',
					rowSelector: '> li',
					tolerance: 85,
					submenuDirection: 'left',
					activate: WallNotifications.openNotifications,
					deactivate: WallNotifications.closeNotifications,
					enter: WallNotifications.openNotifications,
					exitMenu: WallNotifications.closeNotifications
			});
		});
	}
);
