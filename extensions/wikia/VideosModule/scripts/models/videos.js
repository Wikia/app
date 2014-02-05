define( 'videosmodule.models.videos', [
	'wikia.nirvana'
], function( nirvana ) {
	'use strict';

	var VideosData = function( options ) {
		this.verticalOnly = options.verticalOnly;
		this.data = null;
		this.articleId = window.wgArticleId;
	};

	VideosData.prototype.fetch = function() {
		var ret,
				self = this;

		if ( this.data !== null ) {
			ret = this.data;
		} else {
			ret = nirvana.getJson(
				'VideosModuleController',
				'index',
				{
					articleId: this.articleId,
					verticalonly: this.verticalonly
				}
			).done( function( data ) {
				self.data = data;
			} );
		}
		return ret;
	};

	return VideosData;
} );
