/**
 * View for carousel wrapper.  Data is category display title and thumbs list
 */
define( 'videohomepage.views.carousel', [
	'videopageadmin.collections.categorydata',
	'shared.views.carouselthumb',
	'shared.views.owlcarousel',
	'templates.mustache'
], function(
	CategoryDataCollection,
	CarouselThumbView,
	OwlCarouselBase,
	templates
) {
	'use strict';

	var CarouselView = OwlCarouselBase.extend( {
		initialize: function() {
			this.collection = new CategoryDataCollection( this.model.get( 'thumbnails' ).slice( 0, 24 ) );
			if ( this.collection.length ) {
				this.collection.add( {
					count: 8238,
					link: '<a href="#">See more videos</a>',
					type: 'redirect'
				} );
			}
			this.render();
		},
		template: Mustache.compile( templates.carousel ),
		render: function() {
			var self = this;

			this.$el.html( this.template( this.model.toJSON() ) );
			this.$carousel = this.$el.find( '.category-carousel' );

			this.collection.each( function( categoryData ) {
				var view = new CarouselThumbView( {
					model: categoryData
				} );
				self.$carousel.append( view.$el );
			} );

			this.renderCarousel( {
				scrollPerPage: true,
				pagination: true,
				paginationSpeed: 500,
				lazyLoad: true,
				navigation: true,
				rewindNav: false,
				afterUpdate: function() {
					self.resizeLastSlide();
				}
			} );

			return this;
		},
		resizeLastSlide: function() {
			var height,
					$lastSlide;

			height = this.$el.find( '.owl-item:first-child img' ).height();
		}
	} );

	return CarouselView;
} );
