define( 'views.videopagetool.carousel', [
	'collections.videohomepage.categorycarousel',
    'models.videohomepage.categorythumb',
    'models.videohomepage.categorycarousel',
    'views.videopagetool.carouselthumb'
], function( CategoryCarouselCollection, CategoryThumbModel, CategoryCarouselModel, CarouselThumbView ) {
	'use strict';

	var CarouselView = Backbone.View.extend( {
		tagName: 'div',
		className: '.carousel-wrapper',
		initialize: function( options ) {
			var thumbnails = [];

			_.each( options.thumbnails, function( value ) {
				thumbnails.push( new CategoryThumbModel( value ) );
			} );

			this.collection = new CategoryCarouselCollection( thumbnails );
			this.model = new CategoryCarouselModel( { displayTitle: options.displayTitle } );

			this.render();
		},
		template: Mustache.compile( $( '#carousel-wrapper' ).html() ),
		render: function() {
			var that = this,
				view;

			this.$el.html( this.template( this.model.attributes ) );

			this.collection.each( function( model ) {
				view = new CarouselThumbView({
					model: model,
					parentView: that
				});
				that.$el.append( view.$el );
			});

			return this;
		}
	} );

	return CarouselView;
} );