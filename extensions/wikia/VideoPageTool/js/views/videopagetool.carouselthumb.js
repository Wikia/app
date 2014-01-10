/**
 * view for individual carousel thumbs. Data is thumbnail and video title
 */
define( 'views.videopagetool.carouselthumb', [
	'jquery',
	'templates.mustache'
], function( $, templates ) {
	'use strict';

	var CarouselThumbbView = Backbone.View.extend( {
		initialize: function() {
			this.render();
		},
		tagName: 'div',
		className: 'carousel-item',
		template: Mustache.compile( templates.carouselThumb ),
		render: function() {
			var html = this.template( this.model.toJSON() );
			this.$el.html( html );
			return this;
		}
	} );

	return CarouselThumbbView;
});
