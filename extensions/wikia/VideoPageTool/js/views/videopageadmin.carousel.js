/**
 * View for carousel wrapper.  Data is category display title and thumbs list
 */
define( 'views.videopageadmin.carousel', [
	'views.videopagetool.owlcarousel',
	'views.videopagetool.carouselthumb',
	'templates.mustache'
], function(
	OwlCarouselView,
	CarouselThumbView,
	templates
) {
	'use strict';

	var AdminCarouselView = OwlCarouselView.extend( {
		initialize: function() {
			_.bindAll( this, 'render' );
			this.collection.on( 'reset', this.render );
		},
		template: Mustache.compile( templates.adminCarousel ),
		render: function() {
			var self = this;
			this.$el.html( this.template() );
			this.$carousel = this.$el.find( '.category-carousel' );

			this.collection.each( function( categoryData ) {
				var view = new CarouselThumbView( {
					model: categoryData
				} );
				self.$carousel.append( view.$el );
			} );

			this.renderCarousel( {
				items: 3,
				lazyLoad: false,
				navigation: false,
				pagination: false
			} );
			return this;
		}
	} );
	return AdminCarouselView;
} );
