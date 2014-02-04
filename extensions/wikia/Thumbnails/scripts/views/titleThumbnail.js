define( 'thumbnails.titlethumbnail', [
	'thumbnails.templates.mustache',
    'wikia.mustache'
], function( templates, Mustache ) {
	'use strict';

	function TitleView( model ) {
		this.model = model;
	}

	TitleView.prototype = {
		render: function() {
			return Mustache.render( templates.titleThumbnail, this.model );
		},
		constructor: TitleView
	};

	return TitleView;
} );