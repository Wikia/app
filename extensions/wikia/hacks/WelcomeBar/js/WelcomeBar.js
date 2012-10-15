var WelcomeBar = {
	STORAGE_TIMESTAMP: 'welcome-bar-timestamp',
	SHOW_DELAY: 7 * 24 * 3600,
	ANIMATION_DELAY: 75,

	bar: false,

	show: function() {
		var content = $.msg('welcome-bar-message', '<a href="' + wgServer + '">' + wgSiteName + '</a>') +
			'<img class="close" src="' + stylepath + '/oasis/images/icon_close.png" width="15" height="15">';

		this.bar = $('<div>', {id: 'WelcomeBar'}).
			html(content).
			insertBefore('#WikiaHeader').
			slideDown(1000).
			// an extra blink
			delay(1000).
			animate({'opacity': 0.2}, this.ANIMATION_DELAY).delay(this.ANIMATION_DELAY).
			animate({'opacity': 1}, this.ANIMATION_DELAY).
			animate({'opacity': 0.2}, this.ANIMATION_DELAY).delay(this.ANIMATION_DELAY).
			animate({'opacity': 1}, this.ANIMATION_DELAY);

		this.bar.children('.close').bind('click', $.proxy(this.close, this));
	},

	close: function() {
		this.bar.slideUp(1000);

		// wait at least SHOW_DELAY before showing the toolbar the next time
		$.storage.set(this.STORAGE_TIMESTAMP, this.now());
	},

	now: function() {
		return Math.round(new Date().getTime() / 1000);
	},

	checkShow: function() {
		var lastTimeClosed = $.storage.get(this.STORAGE_TIMESTAMP);
		return (lastTimeClosed === null) || (this.now() - lastTimeClosed > this.SHOW_DELAY);
	},

	init: function() {
		if (this.checkShow()) {
			$.getResources([
					function(cb) {$.getMessagesForContent('WelcomeBar', cb);},
					$.getSassCommonURL('extensions/wikia/hacks/WelcomeBar/css/WelcomeBar.scss')
				],
				$.proxy(this.show, this));
		}
	}
}