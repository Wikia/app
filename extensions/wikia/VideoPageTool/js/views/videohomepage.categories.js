define( 'views.videohomepage.categories', [
	'collections.videohomepage.categorycarousel',
    'models.videohomepage.categorythumb',
    'models.videohomepage.categorycarousel',
    'views.videopageadmin.categorythumb'
], function( CategoryCarouselCollection, CategoryThumbModel, CategoryCarouselModel, CategoryThumbView ) {
	'use strict';

	var CategoriesView;

	CategoriesView = Backbone.View.extend( {
		//events: {},
		initialize: function( options ) {
			var thumbnails = [];

			_.each( options.thumbnails, function( value, key, list ) {
				thumbnails.push( new CategoryThumbModel( value ) );
			} );

			this.thumbModels = thumbnails;
			this.collection = new CategoryCarouselCollection( thumbnails );
			this.model = new CategoryCarouselModel( { displayTitle: options.displayTitle } );

			this.render();
		},
		template: Mustache.compile( $( '#carousel-wrapper' ).html() ),
		render: function() {
			var that = this,
				view;

			this.$el.append( this.template( this.model.attributes ) );
			this.results = [];

			this.collection.each( function( model ) {
				view = new CategoryThumbView({
					model: model,
					parentView: that
				});
				that.results.push( view );
				that.$el.find( '.category-carousel' ).append( view.render().$el );
			});

			return this;
		}
	} );

	return CategoriesView;
} );