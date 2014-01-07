define( 'views.videopagetool.carouselthumb', [
	'jquery'
], function( $ ) {
	'use strict';

	var CarouselThumbbView = Backbone.View.extend( {
		initialize: function() {
			this.render();
		},
		tagName: 'div',
		className: 'carousel-item',
		template: Mustache.compile( $( '#thumb-wrapper' ).html() ),
		render: function() {
			var html = this.template( this.model.toJSON() );
			this.$el.html( html );
			return this;
		}
	} );

	return CarouselThumbbView;
});
