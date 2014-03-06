define('videohomepage.views.carouselThumb', [
	'shared.views.carouselThumb',
	'wikia.tracker'
], function (CarouselThumb, Tracker) {
	'use strict';
	var track,
		VideoHomeCarouselThumb;

	track = Tracker.buildTrackingFunction({
		category: 'video-home-page',
		trackingMethod: 'both',
		action: Tracker.ACTIONS.CLICK
	});

	VideoHomeCarouselThumb = CarouselThumb.extend({
		initialize: function (opts) {
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
				categoryModules,
				modulePosition;

			tar = evt.target;

			categoryModules = this.$el
				.closest('.latest-videos-wrapper')[0]
				.children;

			modulePosition = Array.prototype.indexOf.call(categoryModules, this.$el.closest('.carousel-wrapper')[0]);
			track({
				label: 'category-carousel-position-' + modulePosition,
				value: this.model.collection.indexOf(this.model)
			});
		}
	});

	return VideoHomeCarouselThumb;
});
