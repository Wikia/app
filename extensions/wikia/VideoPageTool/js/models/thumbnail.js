define( 'models.videopageadmin.thumbnail', [
		'jquery'
], function( $ ) {
	'use strict';
	function ThumbnailModel( params ) {
		this.imgTitle = params.imgTitle;
		this.wikiText = params.wikiText;
	}

	ThumbnailModel.prototype = {
		create: 
	};

	return ThumbnailModel;
});
