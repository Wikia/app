/**
 * view for individual carousel thumbs. Data is thumbnail and video title
 */
define( 'shared.views.carouselthumb', [
	'jquery',
	'videopagetool.templates.mustache'
], function( $, templates ) {
	'use strict';

	var CarouselThumbView = Backbone.View.extend( {
		initialize: function() {
			if ( this.model.get( 'type' ) === 'redirect' ) {
				this.template = Mustache.compile( templates.carouselLastThumb );
			} else {
				this.template = Mustache.compile( templates.carouselThumb );
			}
			this.render();
		},
		tagName: 'div',
		className: 'carousel-item',
		render: function() {
			var html = this.template( this.model.toJSON() );
			this.$el.html( html );
			return this;
		}
	} );

	return CarouselThumbView;
} );
