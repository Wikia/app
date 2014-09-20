define('shared.views.owlcarousel', [], function () {
	'use strict';
	var OwlCarouselView = Backbone.View.extend({
		tagName: 'div',
		className: 'carousel-wrapper',
		$carousel: null,
		renderCarousel: function (config) {
			var params = _.extend({
				items: 5,
				itemsDesktop: [1599, 4],
				scrollPerPage: true,
				pagination: true,
				paginationSpeed: 1000,
				lazyLoad: true,
				navigation: true,
				rewindNav: false
			}, config);
			this.$carousel.owlCarousel(params);
			return this;
		},
		getCarouselInstance: function () {
			return this.$carousel.data('owlCarousel');
		}
	});
	return OwlCarouselView;
});
