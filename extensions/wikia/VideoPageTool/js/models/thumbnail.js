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
			var that = this;

			return $.nirvana.sendRequest({
					controller: 'VideoPageAdminSpecial',
					method: 'getImageData',
					data: {
						imageTitle: that.imgTitle
					},
			});
		}
	};

	return ThumbnailModel;
});
