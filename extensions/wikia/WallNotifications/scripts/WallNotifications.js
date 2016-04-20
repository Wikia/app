var $window = $(window);
var WallNotifications = $.createClass(Object, {
	constructor: function() {
		this.bucky = window.Bucky('WallNotifications');
		this.isMonobook = false;
		this.updateInProgress = false; // we only want 1 update simultaneously
		this.notificationsCache = {}; // HTML for "trays" for different Wiki ids
		this.wikiShown = {}; // all open "trays" (Wiki Notifications) - list of Wiki ids
		this.fetchedCurrent = false; // we only want to force-fetch notifications for current Wiki once
		this.currentWikiId = 0; // updated after fetching Notification counts for the 1st time
		setTimeout( this.proxy( this.updateCounts ), 300);

		this.$bubblesCount = $('#bubbles_count');
		this.$wallNotifications = $('#WallNotifications, .wall-notifications-monobook');
		this.$wallNotificationsReminder = $('#WallNotificationsReminder');
		this.$wallNotificationsSubnav = this.$wallNotifications.find('.subnav');

		// Used by notifications reminder
		this.reminderTimer = null;
		this.reminderOffsetTop = 100;
		this.unreadCount = parseInt(this.$bubblesCount.html());

		var $wallNotificationsMonobook = $('.wall-notifications-monobook');

		this.isMonobook = $wallNotificationsMonobook.length > 0;

		if (this.isMonobook) {
			$wallNotificationsMonobook.first()
				.append('<span class="count">(?)</span>')
				.click( this.proxy( this.clickNotificationsMonobook ) )
				.parent()
				.append('<table id="wall-notifications-dropdown"><tr><td><ul id="wall-notifications-inner"></ul></td></tr></table>')
				.click( this.proxy( this.updateCounts ) )
				.click( this.proxy( this.fetchForCurrentWiki ) );
			var bgcolor = $('#wall-notifications-dropdown').css('background-color');
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit' || bgcolor == 'rgba(0, 0, 0, 0)') {
				bgcolor = $('body').css('background-color');
			}
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit' || bgcolor == 'rgba(0, 0, 0, 0)' || bgcolor == 'transparent') {
				bgcolor = 'white';
			}

			$('#wall-notifications-dropdown')
				.css('background-color', bgcolor)
				.mouseleave( this.proxy( this.dropdownHide ) );
		} else {
			this.$wallNotifications
				.mouseenter( this.proxy( this.updateCounts ) )
				.mouseenter( this.proxy( this.fetchForCurrentWiki ) )
				.one( 'mouseenter', this.proxy( this.hideReminder ) );

			$window.on( 'scroll.WallNotificationsReminder', $.throttle( 100, this.proxy( this.showReminder )));

			this.$wallNotificationsReminder.on( 'click', 'a', this.proxy(function() {
				if($.browser.msie) { /* JSlint ignore */
					$("html:not(:animated),body:not(:animated)").css({ scrollTop: 0 });
				} else {
					$("html:not(:animated),body:not(:animated)").animate({ scrollTop: 0 }, 500 );
				}

				this.$wallNotificationsReminder.stop().fadeOut( 200 );
			}));
		}

		this.$wallNotifications.add( $('#pt-wall-notifications') )
			.on('click', '#wall-notifications-markasread-sub', this.proxy( this.markAllAsReadPrompt ))
			.on('click', '#wall-notifications-markasread-this-wiki', this.proxy( this.markAllAsRead ))
			.on('click', '#wall-notifications-markasread-all-wikis', this.proxy( this.markAllAsReadAllWikis ));
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
			this.$wallNotifications.trigger('mouseenter');
			this.$wallNotificationsSubnav.addClass('show');
		}
	},

	updateCounts: function() {
		this.bucky.timer.start('updateCounts');
		var data,
			callback = this.proxy(function(data) {

			if (data.status != true || data.html == '') {
				return;
			}

			if (data.count) {
				this.$wallNotifications.removeClass('prehide');
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

			this.bucky.timer.stop('updateCounts');
		});

		if ( this.updateInProgress == false ) {
			this.updateInProgress = true;

			data = this.getUrlParams();

			$.nirvana.sendRequest({
				controller: 'WallNotificationsExternalController',
				method: 'getUpdateCounts',
				format: 'json',
				type: 'GET',
				data: data,
				callback: callback
			});
		}
	},

	fetchForCurrentWiki: function() {
		this.bucky.timer.start('fetchForCurrentWiki');
		if ( this.fetchedCurrent == false ) {
			var wikiEl = ( this.isMonobook ? $('#wall-notifications-inner') : this.$wallNotifications ).find('.notifications-for-wiki').first(),
				firstWikiId = parseInt(wikiEl.attr('data-wiki-id'));

			if ( !isNaN(firstWikiId) ) {
				wikiEl.addClass('show');
				this.fetchedCurrent = true;
				this.currentWikiId = firstWikiId;
				this.wikiShown[ firstWikiId ] = true;
				this.updateWiki( firstWikiId );
				this.bucky.timer.stop('fetchForCurrentWiki');
			}
		}
	},

	restoreFromCache: function() {
		// after updating counts we update DOM, so all notifications are empty
		// we update them from cache for all those that still have the same
		// amount of unread notifications and fetch all the others
		for (var wikiId in this.notificationsCache) {
			this.updateWiki( wikiId );
		}
	},

	clickNotificationsMonobook: function(e) {
		e.preventDefault();
		if( $('#wall-notifications-dropdown').css('display') == 'none' ) {
			this.dropdownShow();
		} else {
			this.dropdownHide();
		}
	},

	dropdownShow: function() {
		$('#wall-notifications-dropdown').show();
	},

	dropdownHide: function() {
		$('#wall-notifications-dropdown').hide();
	},

	markAllAsReadRequest: function(forceAll) {
		this.bucky.timer.start('markAllAsReadRequest');
		$.nirvana.sendRequest({
			controller: 'WallNotificationsExternalController',
			method: 'markAllAsRead',
			format: 'json',
			type: 'POST',
			data: {
				forceAll: forceAll
			},
			callback: this.proxy(function(data) {
				if (data.status != true) {
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

	markAllAsReadPrompt: function(e) {
		$('#wall-notifications-markasread-sub-opts').show();
		$('#wall-notifications-dropdown').show();
		var $markAsRead = $('#wall-notifications-markasread');
		var height = $markAsRead.outerHeight()+4;
		$markAsRead.closest('li').css({'height':height});
		$('#wall-notifications-markasread-sub').addClass('disabled');

		return false;
	},

	markAllAsRead: function(e) {
		this.markAllAsReadRequest( false );
		return false;
	},

	markAllAsReadAllWikis: function(e) {
		this.markAllAsReadRequest( 'FORCE' );
		return false;
	},

	showFirst: function() {
		var wikiEl = ( this.isMonobook ? $('#wall-notifications-inner') : this.$wallNotifications ).find('.notifications-for-wiki').first(),
			firstWikiId = parseInt(wikiEl.attr('data-wiki-id'));

		if ( !isNaN(firstWikiId) ) {
			wikiEl.addClass('show');
			this.wikiShown = {};
			this.wikiShown[ firstWikiId ] = true;
		}
	},

	updateCountsHtml: function(data) {
		if (this.isMonobook) {
			$('.wall-notifications-monobook .count').html('(' + data.count + ')');
			$('#wall-notifications-inner').html(data.html);
			$('#wall-notifications-inner .notifications-wiki-header').click( this.proxy( this.wikiClick ) );
		} else {
			this.$wallNotificationsSubnav.html(data.html);
			this.unreadCount = data.count;
			if (data.count > 0) {
				this.$bubblesCount.html(data.count).parent().addClass('reddot');

			} else {
				this.$bubblesCount.empty().parent().removeClass('reddot');
			}

			this.$wallNotificationsReminder.find('a').html(data.reminder);

			this.$wallNotificationsSubnav.find('.notifications-wiki-header').click( this.proxy( this.wikiClick ) );
		}

	},

	wikiClick: function(e) {
		var wikiEl = $(e.target).closest('.notifications-for-wiki');
		if(wikiEl.hasClass('show') ) {
			wikiEl.removeClass('show');
			var wikiId = parseInt(wikiEl.attr('data-wiki-id'));
			delete this.wikiShown[ wikiId ];
		} else {
			wikiEl.addClass('show');
			var wikiId = parseInt(wikiEl.attr('data-wiki-id'));
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
		var data = this.notificationsCache[ wikiId ];
		var wikiCount =  ( this.isMonobook ? $('#wall-notifications-inner') : this.$wallNotificationsSubnav )
			.find('li[data-wiki-id=' + wikiId + '] .notifications-wiki-count').text();

		// no change in notifications, update from cache
		if ( wikiCount == data[ 'unread' ] ) {
			this.updateWikiHtml( wikiId, data );

		// different number of unread, fetch from server
		// in the meantime, show old data
		} else {
			this.updateWikiHtml( wikiId, data );
			this.updateWikiFetch( wikiId );
		}
	},

	updateWikiFetch: function(wikiId) {
		var isCrossWiki = (wikiId == wgCityId) ? '0' : '1',
			data = {
				wikiId: wikiId,
				isCrossWiki: isCrossWiki
			};

		$.extend(data, this.getUrlParams(data));

		$.nirvana.sendRequest({
			controller: 'WallNotificationsExternalController',
			method: 'getUpdateWiki',
			type: 'GET',
			data: data,
			callback: this.proxy(function(data) {
				if(data.status != true || data.html == '') return;
				this.updateWikiHtml(wikiId, data);
				this.notificationsCache[ wikiId ] = data;
			}),
			onErrorCallback: this.proxy(function(jqXHR, textStatus, errorThrown) {
				if( jqXHR !== undefined && jqXHR.status !== undefined && jqXHR.status == 501) {
					var data = {};
					data.html = '<li class="notifications-empty">' + $.msg('wall-notifications-wall-disabled') + '</li>';
					this.updateWikiHtml(wikiId, data);
					this.notificationsCache[ wikiId ] = data;
				}
			})
		});
	},

	updateWikiHtml: function( wikiId, data ) {
		var wikiEl = ( this.isMonobook ? $('#wall-notifications-inner') : this.$wallNotificationsSubnav ).find('li[data-wiki-id=' + wikiId + ']');
		var wikiLi = wikiEl.find('.notifications-for-wiki-list');

		wikiLi.html(data.html);

		if ( this.wikiShown[ wikiId ] ) {
			wikiEl.addClass('show');
		}

		wikiLi.find('.timeago').timeago();

		// hijack links for other wikis - open them in new window
		if ( wikiId != this.currentWikiId ) {
			wikiEl.find('a').attr('target', '_blank');

			// temporary fix, should be changed on server side
			wikiEl.find('.read_notification').remove();
		}
	},

	showReminder: function() {
		var showReminder = $window.scrollTop() > this.reminderOffsetTop;

		if ( !this.reminderTimer && showReminder ) {
			if ( this.unreadCount > this.getLastSeenCount() ) {
				this.setLastSeenCount( this.unreadCount );
				this.reminderTimer = setTimeout( this.proxy( this.hideReminder ), 3000 );
				this.$wallNotificationsReminder.fadeIn();
			}

		} else if ( this.reminderTimer && !showReminder ) {
			this.hideReminder( true );
		}
	},

	hideReminder: function( hide ) {
		clearTimeout( this.reminderTimer );
		$window.off( 'scroll.WallNotificationsReminder' );
		this.$wallNotificationsReminder[ hide ? 'hide' : 'fadeOut' ]();
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

	getUrlParams: function() {
		var data = {},
			qs = Wikia.Querystring(),
			lang, skin;

		skin = qs.getVal( 'useskin' );
		if( skin ) {
			data.useskin = skin;
		}

		lang = qs.getVal( 'uselang' );
		if( lang ) {
			data.uselang = lang;
		}

		return data;
	}
});

$(function() {
	var wall_notifications = new WallNotifications();
});
