/**
 * $.fn.ellipses
 * @author Liz Lee <lizlee at wikia dash inc dot com>
 * @author Kenneth Kouot <kenkouot at wikia dash inc dot com>
 * @description A jQuery plugin for applying ellipses to text that wraps over one line (which could otherwise be
 * handled by CSS)
 */
(function (exports) {
	'use strict';
	var factory = function ($) {
		function Ellipses($el, opts) {
			this.$el = $el;
			if (opts) {
				$.extend(this.settings, opts);
			}
			this.cleanUp();
			this.render();
		}

		Ellipses.prototype = {
			settings: {
				marginLeft: -3,
				maxLines: 2,
				// words hidden on last visible line
				wordsHidden: 1
			},
			/**
			 * cleanUp
			 * @description Cleans up previous ellipses elements before applying new ones
			 */
			cleanUp: function () {
				this.$el.find('.ellipses').remove();
			},
			render: function () {
				var oText = this.$el.text(),
					words = oText.split(' '),
					len = words.length,
					i,
					$spans,
					lineCount = 0,
					maxLines = this.settings.maxLines,
					$tar,
					spanTop = null,
					currSpanTop,
					self;

				self = this;

				for (i = 0; i < len; i++) {
					words[i] = '<span>' + words[i] + '</span>';
				}

				this.$el.html(words.join(' '));

				$spans = this.$el.find('span');

				for (i = 0; i < $spans.length; i++) {
					$tar = $($spans[i]);

					currSpanTop = $tar.offset().top;

					// if it's the first span, set the value and move on
					if (spanTop === null) {
						spanTop = currSpanTop;
					} else if (lineCount === maxLines) {
						// hide everthing if we've already reached our max lines
						$tar.hide();
					} else {
						if (spanTop !== currSpanTop) {
							// we're at a new line, increment lineCount
							lineCount += 1;
							// update span top with the new y coordinate
							spanTop = currSpanTop;
						}

						if (lineCount === maxLines) {
							// hide the first word on the new line and the nth word in
							// the line before the max lines
							// reached
							$tar
								.hide()
								.prevUntil(':nth-child( ' + (i - self.settings.wordsHidden) + ' )')
								.hide()
								.eq(0)
								.before('<span class="ellipses" style="">...</span>');

							self.trim();
						}
					}
				}
			},
			/**
			 * trim
			 * @description method that aims to achieve balance between clean ellipses implementation
			 * and performance. Uses CSS to position ellipses appropriate to hide last whitespace and also trims
			 * dashes.
			 */
			trim: function () {
				var $ellipses,
					$prev;

				$ellipses = this.$el.find('.ellipses');
				$prev = $ellipses.prev('span');

				$ellipses.css({
					marginLeft: this.settings.marginLeft
				});

				if ($prev.text() === '-') {
					$prev.hide();
				}
			}
		};

		$.fn.ellipses = function (opts) {
			return this.each(function () {
				var $this = $(this);
				$this.data('ellipses', new Ellipses($this, opts));
			});
		};
	};

	factory(exports.jQuery);
})(this);
