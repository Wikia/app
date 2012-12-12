(function($) {
	var FirefoxFindFix = {

		scrollThreshold: 30,
		lastScroll: 0,

		init: function() {
			$(window)
				.scroll($.proxy(this.analyze, this))
				.mousedown($.proxy(this.cancelTimer, this));
		},

		/**
		 * Determines if the scroll position should be adjusted based on highlighted text and amount of scroll.
		 */
		analyze: function() {
			// Is anything highlighted?
			if (window.getSelection().toString()) {

				var currentScroll = $(window).scrollTop();

				// Did we just scroll a lot?
				if (currentScroll > this.lastScroll + this.scrollThreshold) {
					this.adjust();
				}

				this.lastScroll = currentScroll;
			}
		},

		/**
		 * Scrolls the window a bit and begins monitoring
		 */
		adjust: function() {
			// Scroll a little bit more, just to be safe.
			$(window).scrollTop($(window).scrollTop() + this.scrollThreshold);

			// Start monitoring for a minor shift in highlighted text.
			this.anchorOffset = window.getSelection().anchorOffset;
			if (!this.timer) {
				this.timer = setInterval(this.monitorHighlight, 250);
			}
		},

		/**
		 * Monitors the position of highlighted text relative to its parent. This will catch repeat occurances in a sentence.
		 */
		monitorHighlight: function() {
			// Has the offset of the highlighted text changed?
			if (window.getSelection().anchorOffset != this.anchorOffset) {
				if (this.timer) {
					this.adjust();
				}
			}
		},

		/**
		 * Stops the monitoring interval timer
		 */
		cancelTimer: function() {
			if (this.timer) {
				clearInterval(this.timer);
				this.timer = null;
			}
		}

	};


	if ($.browser.mozilla) {
		$(function() {
			if ($("#WikiaFooter .toolbar").exists()) {
				FirefoxFindFix.init();
			}
		});
	}
}(jQuery));
