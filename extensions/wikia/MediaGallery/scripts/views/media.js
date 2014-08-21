define('mediaGallery.media', [], function () {
	'use strict';

	function Media(options) {
		this.$el = options.$el;
		this.$caption = this.$el.find('.caption');
	}

	Media.prototype.init = function () {
		this.setupCaption();
		this.initTracking();
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
		var mediaPadding = parseFloat(this.$el.css('padding-bottom')),
			mediaHeight = this.$el.height(),
			captionPadding = parseFloat(this.$caption.css('padding-top')),
			contentHeight,
			newMarginTop;

		// use css to expand caption content (i.e. remove overflow restrictions)
		this.$caption.addClass('hovered');

		// calculate height of content plus padding of it's container
		contentHeight = this.$caption.find('.inner').outerHeight() + (2 * captionPadding);

		// get new negative top margin but limit it to 100% of it's container; adjust for container padding.
		newMarginTop = -1 * (Math.min(mediaHeight, contentHeight) + mediaPadding);

		this.$caption.css('marginTop', newMarginTop);
	};

	Media.prototype.captionHoverOut = function () {
		this.$caption
			.removeClass('hovered')
			.removeAttr('style');
	};

	Media.prototype.initTracking = function () {
		this.$el.on('click', function () {
			Wikia.Tracker.track({
				category: 'MediaGallery',
				action: Wikia.Tracker.ACTIONS.click,
				label: 'show-new-gallery-lightbox',
				trackingMethod: 'both',
				value: 0
			});
		});
	};

	return Media;
});
