/**
 * View for carousel wrapper.  Data is category display title and thumbs list
 */
define( 'views.videopagetool.carousel', [
	'collections.videopageadmin.categorydata',
	'models.videohomepage.categorythumb',
	'models.videohomepage.categorycarousel',
	'views.videopagetool.carouselthumb',
	'templates.mustache'
], function(
	CategoryDataCollection,
	CategoryThumbModel,
	CategoryCarouselModel,
	CarouselThumbView,
	templates
) {
	'use strict';

	var CarouselView = Backbone.View.extend( {
		tagName: 'div',
		className: 'carousel',
		initialize: function() {
			this.collection = new CategoryDataCollection( this.model.attributes.thumbnails );
			this.render();
		},
		template: Mustache.compile( templates.carousel ),
		events: {
			'click .control[data-direction="left"]': 'slideLeft',
			'click .control[data-direction="right"]': 'slideRight',
		},
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

			this.$carousel.owlCarousel( {
				scrollPerPage: true,
				pagination: true,
				paginationSpeed: 500,
				lazyLoad: true,
				navigation: true,
				rewindNav: false
			} );

			return this;
		},
		slideRight: function() {
			this.$carousel.trigger( 'owl.next' );
		},
		slideLeft: function() {
			this.$carousel.trigger( 'owl.prev' );
		}
	} );

	return CarouselView;
} );
