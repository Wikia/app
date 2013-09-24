define( 'views.videopageadmin.thumbnailUpload', [
		'jquery',
		'wikia.aim',
		'wikia.window',
	], function( $, window ) {
	'use strict';
	function ThumbnailUploader( opts ) {
		this.$el = $( opts.el );
		this.$window = $( window );
		this.init();
	}

	ThumbnailUploader.prototype = {
		init: function() {
			this.$window.on( 'WMU_addFromSpecialPage', $.proxy( this.onUserUpload, this ) );
			this.$el.on( 'click', $.proxy( this.showUploader, this ) );
		},
		showUploader: function() {
			window.WMU_skipDetails = true;
			window.WMU_show();
			window.WMU_openedInEditor = false;
		},
		onUserUpload: function(evt, data) {
			evt.preventDefault();
		}
	};
	return ThumbnailUploader;
});
