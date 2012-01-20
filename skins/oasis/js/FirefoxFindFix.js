var FirefoxFindFix = {

	scrollThreshold: 30,
	lastScroll: 0,

	init: function() {
		$(window)
			.scroll(FirefoxFindFix.analyze)
			.mousedown(FirefoxFindFix.cancelTimer);
	},

	/**
	 * Determines if the scroll position should be adjusted based on highlighted text and amount of scroll.
	 */
	analyze: function() {
		// Is anything highlighted?
		if (window.getSelection().toString()) {

			var currentScroll = $(window).scrollTop();

			// Did we just scroll a lot?
			if (currentScroll > FirefoxFindFix.lastScroll + FirefoxFindFix.scrollThreshold) {
				FirefoxFindFix.adjust();
			}

			FirefoxFindFix.lastScroll = currentScroll;
		}
	},

	/**
	 * Scrolls the window a bit and begins monitoring
	 */
	adjust: function() {
		// Scroll a little bit more, just to be safe.
		$(window).scrollTop($(window).scrollTop() + FirefoxFindFix.scrollThreshold);

		// Start monitoring for a minor shift in highlighted text.
		FirefoxFindFix.anchorOffset = window.getSelection().anchorOffset;
		if (!FirefoxFindFix.timer) {
			FirefoxFindFix.timer = setInterval(FirefoxFindFix.monitorHighlight, 250);
		}
	},

	/**
	 * Monitors the position of highlighted text relative to its parent. This will catch repeat occurances in a sentence.
	 */
	monitorHighlight: function() {
		// Has the offset of the highlighted text changed?
		if (window.getSelection().anchorOffset != FirefoxFindFix.anchorOffset) {
			if (FirefoxFindFix.timer) {
				FirefoxFindFix.adjust();
			}
		}
	},

	/**
	 * Stops the monitoring interval timer
	 */
	cancelTimer: function() {
		if (FirefoxFindFix.timer) {
			clearInterval(FirefoxFindFix.timer);
			FirefoxFindFix.timer = null;
		}
	}

};

$(function() {
	if ($.browser.mozilla && $("#WikiaFooter .toolbar").exists()) {
		FirefoxFindFix.init();
	}
});