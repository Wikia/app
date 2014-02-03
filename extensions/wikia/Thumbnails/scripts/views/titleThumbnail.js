define( 'thumbnails.titlethumbnail', [
	'thumbnails.templates.mustache',
    'wikia.mustache'
], function( templates, Mustache ) {
	'use strict';

	function TitleView( model ) {
		this.model = model;
		this.template = Mustache.compile( templates.titleThumbnail );
	}

	TitleView.prototype = {
		render: function() {
			return Mustache.render( this.template, this.model );
		},
		constructor: TitleView
	};

	return TitleView;
} );