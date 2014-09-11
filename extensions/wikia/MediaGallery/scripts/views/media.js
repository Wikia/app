define('mediaGallery.media', [], function () {
	'use strict';

	function Media(options) {
		this.$el = options.$el;
		this.$caption = this.$el.find('.caption');

		// cache some css values that don't change
		this.mediaPadding = parseFloat(this.$el.css('padding-bottom'));
		this.captionPadding = parseFloat(this.$caption.css('padding-top'));
		this.marginTop = parseFloat(this.$caption.css('margin-top'));
	}

	Media.prototype.init = function () {
		this.setupCaption();
	};

	Media.prototype.setupCaption = function () {
		this.$caption.hover(
			$.proxy(this.captionHover, this),
			$.proxy(this.captionHoverOut, this)
		);
	};

	/**
	 * Toggle top margin to slide caption up into full view.
	 * Note: it's hard to do this animation with css b/c the new top margin value is unknown
	 */
	Media.prototype.captionHover = function () {
		var self = this,
			mediaHeight = this.$el.height(),
			contentHeight,
			newMarginTop;

		// use css to expand caption content (i.e. remove overflow restrictions)
		this.$caption.addClass('hovered');

		// calculate height of content plus padding of it's container
		contentHeight = this.$caption.find('.inner').outerHeight() + (2 * this.captionPadding);

		// get new negative top margin but limit it to 100% of it's container
		// then adjust for container padding
		newMarginTop = -1 * (Math.min(mediaHeight, contentHeight) + this.mediaPadding);

		// handle small rounding inacuracies to avoid blips on hover of short captions
		if (Math.abs(Math.abs(this.marginTop) - Math.abs(newMarginTop)) < 2) {
			return;
		}

		// do the animation
		this.$caption.css('marginTop', newMarginTop);

		// add a scrollbar to long captions
		if (contentHeight > mediaHeight) {
			self.$caption.addClass('scroll');
		}
	};

	Media.prototype.captionHoverOut = function () {
		this.$caption
			.removeClass('hovered scroll')
			.removeAttr('style');
	};

	return Media;
});
