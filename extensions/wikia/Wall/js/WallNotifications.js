$(function() {
	var wall_notifications = new WallNotifications();
});

var WallNotifications = $.createClass(Object, {
	constructor: function() {
		this.wikisUrls = {};
		this.updateInProgress = false; // we only want 1 update simultaneously 
		this.notificationsCache = {}; // HTML for "trays" for different Wiki ids
		this.wikiShown = {}; // all open "trays" (Wiki Notifications) - list of Wiki ids
		this.fetchedCurrent = false; // we only want to force-fetch notifications for current Wiki once
		this.currentWikiId = 0; // updated after fetching Notification counts for the 1st time
		setTimeout( this.proxy( this.updateCounts ), 300);
		//setInterval( this.proxy( this.updateLoop ), 15000);
		
		if($('.wall-notifications-monobook').length > 0) {
			$('.wall-notifications-monobook').first()
				.append('<span class="count">(?)</span>')
				.parent()
				.append('<table id="wall-notifications-dropdown"><tr><td><ul id="wall-notifications-inner"></ul></td></tr></table>')
				.click( this.proxy( this.clickNotificationsMonobook ) )
				.click( this.proxy( this.updateCounts ) )
				.click( this.proxy( this.fetchForCurrentWiki ) );
			var bgcolor = $('#wall-notifications-dropdown').css('background-color');
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit' || bgcolor == 'rgba(0, 0, 0, 0)') {
				bgcolor = $('body').css('background-color');
			}
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit' || bgcolor == 'rgba(0, 0, 0, 0)') {
				bgcolor = 'white';
			}
			
			$('#wall-notifications-dropdown')
				.css('background-color',bgcolor)
				.mouseleave( this.proxy( this.dropdownHide ) );
			
			this.monobook = true;
		} else {
			$('#WallNotifications')
				.mouseenter( this.proxy( this.updateCounts ) )
				.mouseenter( this.proxy( this.fetchForCurrentWiki ) );

			$('#WallNotifications .bubbles').trackClick('wall/notifications/dropdown_open');

			// notifications reminder
			$(document).scroll( this.proxy( this.documentScroll ) );
			$('#WallNotificationsReminder a').click( function() {
				var destination = 0;
				if($.browser.msie) {
					$("html:not(:animated),body:not(:animated)").css({ scrollTop: destination-20});
				} else {
					$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20}, 500 );
				}
				$('#WallNotificationsReminder').stop().fadeOut(200);
			});
			
			this.monobook = false;
		}

		$('.notifications-header')
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
			$('#WallNotifications').trigger('mouseenter');
			$('#WallNotifications .subnav').addClass('show');
		}
	},
	
	updateCounts: function() {
		if( this.updateInProgress == false ) {
			this.updateInProgress = true;
			$.nirvana.sendRequest({
				controller: 'WallNotificationsExternalController',
				method: 'getUpdateCounts',
				format: 'json',
				data: {
					username: wgTitle
				},
				callback: this.proxy(function(data) {
					if(data.status != true || data.html == '') {
						return;
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
					setTimeout( this.proxy( function() {this.updateInProgress = false; } ), 10000 );
				})
			});
		}
	},
	
	fetchForCurrentWiki: function() {
		if( this.fetchedCurrent == false ) {
			if(this.monobook) {
				var wikiEl = $('#wall-notifications-inner li.notifications-for-wiki').first();
			} else {
				var wikiEl = $('#WallNotifications .subnav li.notifications-for-wiki').first();
			}

			var first_wiki_id = wikiEl.attr('data-wiki-id');
			if (first_wiki_id != undefined) {
				this.fetchedCurrent = true;
				wikiEl.addClass('show');
				this.currentWikiId = first_wiki_id;
				this.wikiShown[ first_wiki_id ] = true;
				this.updateWiki( first_wiki_id );
			}
		}
	},
	
	restoreFromCache: function() {
		// after updating counts we update DOM, so all notifications are empty
		// we update them from cache for all those that still have the same
		// amount of unread notifications and fetch all the others
		for(var wikiId in this.notificationsCache)
			this.updateWiki( wikiId );
	},
	
	clickNotificationsMonobook: function() {
		if( $('#wall-notifications-dropdown').css('display') == 'none' ) {
			this.dropdownShow();
			
			this.proxy(function(){
				this.track('wall/notifications/dropdown_open');
			});
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
		$.nirvana.sendRequest({
			controller: 'WallNotificationsExternalController',
			method: 'markAllAsRead',
			format: 'json',
			data: {
				username: wgTitle,
				forceAll: forceAll
			},
			callback: this.proxy(function(data) {
				if(data.status != true) return;
				this.updateCountsHtml(data);
				
				// if we already have data for some Wikis, show it
				this.restoreFromCache();
				
				// make sure user doesn't trap himself
				// (closed tray for current wiki, marks all as read
				//	= tray is hidden (because there are no other wikis with notifications)
				//  = no ability to show notifications, no tray)
				this.showFirst();
				
				//click tracking
				if( forceAll === false && typeof($.tracker) != 'undefined' ) {
					$.tracker.byStr('wall/notifications/mark_all_as_read/this_wiki');
				} else if( forceAll !== false && typeof($.tracker) != 'undefined' ) {
					$.tracker.byStr('wall/notifications/mark_all_as_read/all_wikis');
				} else if( forceAll === false && typeof($.tracker) == 'undefined' ) {
					WET.byStr('wall/notifications/mark_all_as_read/this_wiki');
				} else if( forceAll !== false && typeof($.tracker) == 'undefined' ) {
					WET.byStr('wall/notifications/mark_all_as_read/all_wikis');
				}
			})
	
		});
	},
	
	markAllAsReadPrompt: function(e) {
		e.preventDefault();
		$('#wall-notifications-markasread-sub-opts').show();
		$('#wall-notifications-dropdown').show();
		var height = $('#wall-notifications-markasread').outerHeight()+4;
		$('#wall-notifications-markasread').closest('li').css({'height':height});
		$('#wall-notifications-markasread-sub').addClass('disabled');
		
		//click tracking
		if( typeof($.tracker) != 'undefined' ) {
			$.tracker.byStr('wall/notifications/mark_all_as_read/click');
		} else {
			WET.byStr('wall/notifications/mark_all_as_read/click');
		}
		
		return false;
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
		if(this.monobook) {
			var wikiEl = $('#wall-notifications-inner li.notifications-for-wiki');
		} else {
			var wikiEl = $('#WallNotifications .subnav li.notifications-for-wiki');
		}
		if( wikiEl.count <= 1 ) {
			wikiEl.first().addClass('show');
			this.wikiShown = {};
			this.wikiShown[wikiEl.first().attr('data-wiki-id')] = true;
		}
	},
	
	updateCountsHtml: function(data) {
		if(this.monobook) {
			$('.wall-notifications-monobook .count')
				.html('(' + data.count + ')');
			$('#wall-notifications-inner').html(data.html);
			$('#wall-notifications-inner .notifications-wiki-header').click( this.proxy( this.wikiClick ) );
		} else {
			var subnav = $('#WallNotifications .subnav');
			subnav.html(data.html);
			if(data.count > 0) {
				$('#bubbles_count').html(data.count);
				$('.bubbles').addClass('reddot');
			}
			else {
				$('#bubbles_count').html('');
				$('.bubbles').removeClass('reddot');
			}
			$('#WallNotificationsReminder a').html(data.reminder);
		
			var wikis = $('li.notifications-for-wiki');
			
			var self = this;
			wikis.each(function(index) {
				var element = $(this);
				self.wikisUrls[element.attr('data-wiki-id')] = element.attr('data-wiki-path');
			});
			
			$('.notifications-wiki-header',subnav).click( this.proxy( this.wikiClick ) );
		}
		
	},
	
	wikiClick: function(e) {
		e.preventDefault();
		var wikiEl = $(e.target).closest('.notifications-for-wiki');
		if(wikiEl.hasClass('show') ) {
			wikiEl.removeClass('show');
			var wikiId = wikiEl.attr('data-wiki-id');
			delete this.wikiShown[ wikiId ];
			this.track('wall/notifications/tray_close');
		} else {
			wikiEl.addClass('show');
			var wikiId = wikiEl.attr('data-wiki-id');
			this.wikiShown[ wikiId ] = true;
			this.updateWiki(wikiId);
			this.track('wall/notifications/tray_open');
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
		if(this.monobook) {
			wikiCount = $('#wall-notifications-inner li[data-wiki-id='+wikiId+'] .notifications-wiki-count').text();
		} else {
			wikiCount = $('#WallNotifications .subnav li[data-wiki-id='+wikiId+'] .notifications-wiki-count').text();
		}
		if( wikiCount == data['unread'] ) {
			// no change in notifications, update from cache
			this.updateWikiHtml( wikiId, data );
		} else {
			// different number of unread, fetch from server
			// in the meantime, show old data
			this.updateWikiHtml( wikiId, data );
			this.updateWikiFetch( wikiId );
		}
	},
	
	updateWikiFetch: function(wikiId) {
		var isMain = (wikiId == this.currentWikiId) ? 'YES' : 'NO';
		$.nirvana.sendRequest({
			controller: 'WallNotificationsExternalController',
			method: 'getUpdateWiki',
			format: 'jsonp',
			scriptPath: this.wikisUrls[wikiId],
			data: {
				username: wgTitle,
				wikiId: wikiId,
				isMain: isMain
			},
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

	updateWikiHtml: function(wikiId, data) {
		var wikiEl = null;
		var wikiLi = null;
		if(this.monobook) {
			wikiEl = $('#wall-notifications-inner li[data-wiki-id='+wikiId+']');
			wikiLi = $('#wall-notifications-inner li[data-wiki-id='+wikiId+'] .notifications-for-wiki-list');
		} else {
			wikiEl = $('#WallNotifications .subnav li[data-wiki-id='+wikiId+']');
			wikiLi = $('#WallNotifications .subnav li[data-wiki-id='+wikiId+'] .notifications-for-wiki-list');
		}
		
		wikiLi.html(data.html);
		if( wikiId in this.wikiShown ) {
			wikiEl.addClass('show');
		}
		$('.timeago',wikiLi).timeago();
		
		// hijack links for other wikis - open them in new window
		if( wikiId != this.currentWikiId ) {
			$('a', wikiEl).attr('target', '_blank');
			$('.read_notification', wikiEl).remove(); // temporary fix, should be changed on server side
		}
		
		$('.read_notification').click(this.proxy(function(){
			this.track('wall/notifications/read');
		}));
		
		$('.unread_notification').click(this.proxy(function(){
			this.track('wall/notifications/unread');
		}));
	},
		
	documentScroll: function() {
		var reminderVisible = $('#WallNotificationsReminder').is(':visible');
		var notificationsVisible = $('#WallNotifications .subnav').hasClass('show');
		if( !reminderVisible && !notificationsVisible ) {
			var unreadCount = parseInt($('#bubbles_count').html());
			var lastCount = this.getLastSeenCount()
			if( $(document).scrollTop() > 100 && lastCount != unreadCount ) {
				this.setLastSeenCount(unreadCount);
				if( unreadCount > 0 && lastCount == 0 ) {
					$('#WallNotificationsReminder')
						.fadeIn(500)
						.animate({'opacity':1}, 3000)
						.fadeOut(500);
				}
			}
		} else if( reminderVisible && $(document).scrollTop() == 0) {
			$('#WallNotificationsReminder').hide();
		}
	},
	
	getLastSeenCount: function() {
		var val = $.cookies.get( 'wall_notifications_last_count' );
		if(val != undefined && parseInt(val) > 0)
			return val;
		return 0;
	},
	setLastSeenCount: function(val) {
		$.cookies.set( 'wall_notifications_last_count', val);
	},
	
	proxy: function(func) {
		return $.proxy(func, this);
	},
	
	track: function(url) {
		if( typeof($.tracker) != 'undefined' ) {
		//oasis
			$.tracker.byStr(url);
		} else {
		//monobook
			WET.byStr(url);
		}
	}
});

