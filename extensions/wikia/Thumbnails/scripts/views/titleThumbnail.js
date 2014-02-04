define( 'thumbnails.views.titlethumbnail', [
	'thumbnails.templates.mustache',
    'wikia.mustache'
], function( templates, Mustache ) {
	'use strict';

	function TitleView( model ) {
		this.model = model;
	}

	TitleView.prototype.render = function() {
		this.el = Mustache.render( templates.titleThumbnail, this.model );
		this.$el = $( this.el );
		return this;
	};

	return TitleView;
} );