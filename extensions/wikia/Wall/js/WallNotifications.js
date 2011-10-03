$(function() {
	var wall_notifications = new WallNotifications();
});

var WallNotifications = $.createClass(Object, {
	constructor: function() {
		this.updateInProgress = false;
		setTimeout( this.proxy( this.updateLoop ), 300);
		//setInterval( this.proxy( this.updateLoop ), 5000);
		
		if($('.wall-notifications-monobook').length > 0) {
			$('.wall-notifications-monobook').first()
				.append('<span class="count">(?)</span>')
				.parent()
				.append('<table id="wall-notifications-dropdown"><tr><td><ul id="wall-notifications-inner"></ul></td></tr></table>')
				.click( this.proxy( this.clickNotificationsMonobook ) );
			var bgcolor = $('#wall-notifications-dropdown').css('background-color');
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit')
				bgcolor = $('body').css('background-color');
			if(bgcolor == 'none' || bgcolor == '' || bgcolor == 'inherit')
				bgcolor = 'white';
			
			$('#wall-notifications-dropdown')
				.css('background-color',bgcolor)
				.mouseleave( this.proxy( this.dropdownHide ) );
			
			this.monobook = true;
		} else
			this.monobook = false;
		
		$('#wall-notifications-markasread')
			.live('click', this.proxy( this.markAllAsRead ) );
	},
	
	updateLoop: function() {
		if( this.updateInProgress == false ) {
			this.updateInProgress = true;
			$.nirvana.sendRequest({
				controller: 'WallNotificationsExternalController',
				method: 'getUpdate',
				data: {
					username: wgTitle
				},
				callback: this.proxy(function(data) {
					this.updateHtml(data);
					this.updateInProgress = false;
				})
	
			});
		}
	},
	
	clickNotificationsMonobook: function() {
		if( $('#wall-notifications-dropdown').css('display') == 'none' )
			this.dropdownShow();
		else
			this.dropdownHide();
	},
	
	dropdownShow: function() {
		$('#wall-notifications-dropdown').show();
		//$('#pt-wall-notifications').css('background
	},

	dropdownHide: function() {
		$('#wall-notifications-dropdown').hide();
	},

	
	markAllAsRead: function() {
		$.nirvana.sendRequest({
			controller: 'WallNotificationsExternalController',
			method: 'markAllAsRead',
			data: {
				username: wgTitle
			},
			callback: this.proxy(function(data) {
				this.updateHtml(data);
			})
	
		});		
	},
	
	updateHtml: function(data) {
		$().log(data);
		if(this.monobook) {
			$('.wall-notifications-monobook .count')
				.html('(' + data.count + ')');
			$('#wall-notifications-inner').html(data.html);
			$('#wall-notifications-inner time.timeago').timeago();
		} else {
			var subnav = $('#WallNotifications .subnav');
			subnav.html(data.html);
			$('.timeago', subnav).timeago();
			//$('.timeago', subnav).html('blabla');
			//alert('hi');
			//setTimeout( function() { alert($('TIME.timeago').length;}, 500);
			if(data.count > 0) {
				$('#bubbles_count').html(data.count);
				$('.bubbles').addClass('reddot');
			}
			else {
				$('#bubbles_count').html('');
				$('.bubbles').removeClass('reddot');
			}
		}
	},
	
	proxy: function(func) {
		return $.proxy(func, this);
	}
});

