define('mediaGallery.views.caption', [], function () {
	'use strict';

	var Caption = function (options) {
		this.$el = options.$el;
		this.media = options.media;
		this.$media = this.media.$el;

		// cache some css values that don't change
		this.mediaPadding = parseFloat(this.$media.css('padding-bottom'));
		this.captionPadding = parseFloat(this.$el.css('padding-top'));
		this.marginTop = parseFloat(this.$el.css('margin-top'));

		this.setupCaption();
	};

	Caption.prototype.setupCaption = function () {
		var self = this;

		this.$el.hover(
			$.proxy(this.captionHover, this),
			$.proxy(this.captionHoverOut, this)
		);

		this.$media.on('click', function () {
			if (self.$el.hasClass('clicked')) {
				self.captionHoverOut();
			} else {
				self.$el.addClass('clicked');
				// captionHover here is required for touch screen interactions. mouseenter (bound by
				// hover above) is only triggered for the first click on the caption, unless the user
				// clicks outside the caption. This ensures captionHover will be called either way.
				self.captionHover();
			}
		});
	};

	/**
	 * Toggle top margin to slide caption up into full view.
	 * Note: it's hard to do this animation with css b/c the new top margin value is unknown
	 */
	Caption.prototype.captionHover = function () {
		var self = this,
			mediaHeight = this.$media.height(),
			contentHeight,
			newMarginTop;

		// use css to expand caption content (i.e. remove overflow restrictions)
		this.$el.addClass('hovered');

		// calculate height of content plus padding of it's container
		contentHeight = this.$el.find('.inner').outerHeight() + (2 * this.captionPadding);

		// get new negative top margin but limit it to 100% of it's container
		// then adjust for container padding
		newMarginTop = -1 * (Math.min(mediaHeight, contentHeight) + this.mediaPadding);

		// handle small rounding inacuracies to avoid blips on hover of short captions
		if (Math.abs(Math.abs(this.marginTop) - Math.abs(newMarginTop)) < 2) {
			return;
		}

		// do the animation
		this.$el.css('marginTop', newMarginTop);

		// add a scrollbar to long captions
		if (contentHeight > mediaHeight) {
			self.$el.addClass('scroll');
		}
	};

	Caption.prototype.captionHoverOut = function () {
		this.$el
			.removeClass('hovered scroll clicked')
			.removeAttr('style');
	};

	return Caption;
});
