$(function() {
	var wall_notifications = new WallNotifications();
});

var WallNotifications = $.createClass(Object, {
	constructor: function() {
		this.updateInProgress = false;
		setTimeout( this.proxy( this.updateLoop ), 300);
		//setInterval( this.proxy( this.updateLoop ), 5000);
		
		$('#WallNotifications').mouseenter( this.proxy( this.updateLoop ) );
		
		if($('.wall-notifications-monobook').length > 0) {
			$('.wall-notifications-monobook').first()
				.append('<span class="count">(?)</span>')
				.parent()
				.append('<table id="wall-notifications-dropdown"><tr><td><ul id="wall-notifications-inner"></ul></td></tr></table>')
				.click( this.proxy( this.clickNotificationsMonobook ) );
			var bgcolor = $('#wall-notifications-dropdown').css('background-color');
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit' || bgcolor == 'rgba(0, 0, 0, 0)')
				bgcolor = $('body').css('background-color');
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit' || bgcolor == 'rgba(0, 0, 0, 0)')
				bgcolor = 'white';
			
			$('#wall-notifications-dropdown')
				.css('background-color',bgcolor)
				.mouseleave( this.proxy( this.dropdownHide ) );
			
			this.monobook = true;
		} else
			this.monobook = false;
		
		$('#wall-notifications-markasread')
			.live('click', this.proxy( this.markAllAsRead ) );
		
		if( this.monobook === false ) {
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
		}
		
	},
	
	updateLoop: function() {
		if( this.updateInProgress == false ) {
			this.updateInProgress = true;
			$.nirvana.sendRequest({
				controller: 'WallNotificationsExternalController',
				method: 'getUpdate',
				format: 'json',
				data: {
					username: wgTitle
				},
				callback: this.proxy(function(data) {
					this.updateHtml(data);
					setTimeout( this.proxy( function() {this.updateInProgress = false; } ), 10000 );
				})
			});
		}
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

	
	markAllAsRead: function(e) {
		e.preventDefault();
		$.nirvana.sendRequest({
			controller: 'WallNotificationsExternalController',
			method: 'markAllAsRead',
			format: 'json',
			data: {
				username: wgTitle
			},
			callback: this.proxy(function(data) {
				this.updateHtml(data);
				
				//click tracking
				if( typeof($.tracker) != 'undefined' ) {
					$.tracker.byStr('wall/notifications/mark_all_as_read');
				} else {
					WET.byStr('wall/notifications/mark_all_as_read');
				}
			})
	
		});
		return false;
	},
	
	updateHtml: function(data) {
		if(this.monobook) {
			$('.wall-notifications-monobook .count')
				.html('(' + data.count + ')');
			$('#wall-notifications-inner').html(data.html);
			$('#wall-notifications-inner .timeago').timeago();
		} else {
			var subnav = $('#WallNotifications .subnav');
			subnav.html(data.html);
			$('.timeago', subnav).timeago();
			if(data.count > 0) {
				$('#bubbles_count').html(data.count);
				$('.bubbles').addClass('reddot');
			}
			else {
				$('#bubbles_count').html('');
				$('.bubbles').removeClass('reddot');
			}
			$('#WallNotificationsReminder a').html(data.reminder);
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
			if( $(document).scrollTop() > 100 && this.getLastSeenCount() != unreadCount ) {
				this.setLastSeenCount(unreadCount);
				if( unreadCount > 0 ) {
					var msg = $.msg('wall-notifications-reminder', unreadCount);
					$('#WallNotificationsReminder')
						.fadeIn(500)
						.animate({'opacity':1}, 3000)
						.fadeOut(500);
				}
			}
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

