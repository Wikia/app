/**
 * View for carousel wrapper.  Data is category display title and thumbs list
 */
define( 'videohomepage.views.carousel', [
	'videopageadmin.collections.categorydata',
	'videohomepage.models.categorythumb',
	'videohomepage.models.categorycarousel',
	'shared.views.carouselthumb',
	'shared.views.owlcarousel',
	'templates.mustache'
], function(
	CategoryDataCollection,
	CategoryThumbModel,
	CategoryCarouselModel,
	CarouselThumbView,
	OwlCarouselBase,
	templates
) {
	'use strict';

	var CarouselView = OwlCarouselBase.extend( {
		initialize: function() {
			this.collection = new CategoryDataCollection( this.model.attributes.thumbnails );
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
				rewindNav: false
			} );

			return this;
		}
	} );

	return CarouselView;
} );
