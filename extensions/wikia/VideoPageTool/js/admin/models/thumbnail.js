define( 'videopageadmin.models.thumbnail', [
	'jquery'
], function( $ ) {
	'use strict';
	function ThumbnailModel( params ) {
		this.imgTitle = params.imgTitle;
		this.wikiText = params.wikiText;
	}

	ThumbnailModel.prototype = {
		create: function() {
			var self = this;

			return $.nirvana.sendRequest( {
				controller: 'VideoPageAdminSpecial',
				method: 'getImageData',
				data: {
					imageTitle: self.imgTitle
				}
			} );
		}
	};

	return ThumbnailModel;
} );
