define( 'models.videopageadmin.thumbnail', [
		'jquery'
], function( $ ) {
	'use strict';
	function ThumbnailModel( params ) {
		this.imgTitle = params.imgTitle;
		this.wikiText = params.wikiText;
	}

	ThumbnailModel.prototype = {
		create: function() {
			$.nirvana.sendRequest({
					controller: 'VideoPageAdminSpecial',
					method: 'getImageData',
					data: this.imgTitle,
					callback: function( response ) {
						console.log(response);
					}
			});
		}
	};

	return ThumbnailModel;
});
