define('videohomepage.views.carouselThumb', [
	'shared.views.carouselThumb',
	'wikia.tracker'
], function (CarouselThumb, Tracker) {
	'use strict';
	var track,
		VideoHomeCarouselThumb;

	track = Tracker.buildTrackingFunction({
		category: 'video-home-page',
		trackingMethod: 'analytics',
		action: Tracker.ACTIONS.CLICK
	});

	VideoHomeCarouselThumb = CarouselThumb.extend({
		initialize: function (opts) {
			this.modulePosition = opts.modulePosition;
			_.bindAll(this, 'onClick');
			CarouselThumb.prototype.initialize.call(this, opts);
		},
		events: {
			'click': 'onClick'
		},
		/**
		 * onClick
		 * @description Handler for clicking on entire video thumbnail view, including title
		 * @param evt jQuery event obj
		 */
		onClick: function (evt) {
			var tar,
				categoryModules;

			tar = evt.target;

			categoryModules = this.$el
				.closest('.latest-videos-wrapper')[0]
				.children;

			track({
				label: 'category-carousel-position-' + this.modulePosition,
				value: this.model.collection.indexOf(this.model)
			});
		}
	});

	return VideoHomeCarouselThumb;
});
