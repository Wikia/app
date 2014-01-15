define( 'views.videopagetool.owlcarousel', [
], function() {
	'use strict';
	var OwlCarouselView = Backbone.View.extend({
		tagName: 'div',
		className: 'carousel',
		$carousel: null,
		events: {
			'click .control[data-direction="left"]': 'slideLeft',
			'click .control[data-direction="right"]': 'slideRight',
		},
		renderCarousel: function( config ) {
			var params = _.extend( {
				scrollPerPage: true,
				pagination: true,
				paginationSpeed: 500,
				lazyLoad: true,
				navigation: true,
				rewindNav: false
			}, config );
			this.$carousel.owlCarousel( params );
			return this;
		},
		slideRight: function() {
			this.$carousel.trigger( 'owl.next' );
		},
		slideLeft: function() {
			this.$carousel.trigger( 'owl.prev' );
		},
		getCarouselInstance: function() {
			return this.$carousel.data( 'owlCarousel' );
		}
	});
	return OwlCarouselView;
});
