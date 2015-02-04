define('mediaGallery.views.caption', [], function () {
	'use strict';

	/**
	 * Handle bindings for caption elements. Rendering is already done at this point.
	 * @param {Object} options
	 * @constructor
	 */
	var Caption = function (options) {
		this.$el = options.$el;
		this.media = options.media;
		this.$media = this.media.$el;
	};

	/**
	 * Bind interaction events for touch and non-touch screens
	 */
	Caption.prototype.init = function () {
		var self = this;

		// handle desktop
		this.$el.hover(
			$.proxy(this.expand, this),
			$.proxy(this.collapse, this)
		);

		// handle touch screens
		this.$media.on('click', function () {
			if (self.$el.hasClass('clicked')) {
				self.collapse();
			} else {
				self.$el.addClass('clicked');
				// expand() here is required for touch screen interactions. mouseenter (bound by
				// hover above) is only triggered for the first click on the caption, unless the user
				// clicks outside the caption. This ensures expand will be called either way.
				self.expand();
			}
		});
	};

	/**
	 * Expand caption height so the full caption can be read.
	 * This is done by reducing the top margin of the caption. Uses JS to cacluate and change top margin and css
	 * with animations to do the rest.
	 */
	Caption.prototype.expand = function () {
		var mediaHeight = this.$media.height(),
			contentHeight,
			newMarginTop;

		this.setDimensionsCache();

		// use css to expand caption content (removes overflow restrictions)
		this.$el.addClass('hovered');

		// calculate height of caption content plus padding of it's container
		contentHeight = this.$el.find('.inner').outerHeight(false) + (2 * this.captionPadding);

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
			this.$el.addClass('scroll');
		}
	};

	/**
	 * Set caption height back to one line
	 */
	Caption.prototype.collapse = function () {
		this.$el
			.removeClass('hovered scroll clicked')
			.removeAttr('style');
	};

	/**
	 * Cache some css values that don't change
	 */
	Caption.prototype.setDimensionsCache = function () {
		if (!this.mediaPadding) {
			this.mediaPadding = parseFloat(this.$media.css('padding-bottom'));
			this.captionPadding = parseFloat(this.$el.css('padding-top'));
			this.marginTop = parseFloat(this.$el.css('margin-top'));
		}
	};

	return Caption;
});
