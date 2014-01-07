define( 'views.videopageadmin.categorythumb', [
	'jquery'
], function( $ ) {
	'use strict';

	var CategoryThumbView = Backbone.View.extend( {
		initialize: function( opts ) {
			this.parentView = opts.parentView;
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

	return CategoryThumbView;
});
