define('shared.views.owlcarousel', [], function () {
	'use strict';
	var OwlCarouselView = Backbone.View.extend({
		tagName: 'div',
		className: 'carousel-wrapper',
		$carousel: null,
		events: {
			'click .control[data-direction="left"]': 'slideLeft',
			'click .control[data-direction="right"]': 'slideRight'
		},
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
		slideRight: function () {
			this.$carousel.trigger('owl.next');
		},
		slideLeft: function () {
			this.$carousel.trigger('owl.prev');
		},
		getCarouselInstance: function () {
			return this.$carousel.data('owlCarousel');
		}
	});
	return OwlCarouselView;
});
