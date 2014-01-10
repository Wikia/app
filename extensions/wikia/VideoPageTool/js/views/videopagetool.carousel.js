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
	CategoryDatalCollection,
	CategoryThumbModel,
	CategoryCarouselModel,
	CarouselThumbView,
	templates
) {
	'use strict';

	var CarouselView = Backbone.View.extend( {
		tagName: 'div',
		className: 'carousel-wrapper',
		initialize: function() {
			this.collection = new CategoryDatalCollection( this.model.attributes.thumbnails );
			this.render();
		},
		template: Mustache.compile( templates.carousel ),
		render: function() {
			var $carousel;

			this.$el.html( this.template( this.model.toJSON() ) );

			$carousel = this.$el.find( '.category-carousel' );

			this.collection.each( function( categoryData ) {
				var view = new CarouselThumbView({
					model: categoryData
				} );
				$carousel.append( view.$el );
			} );

			return this;
		}
	} );

	return CarouselView;
} );