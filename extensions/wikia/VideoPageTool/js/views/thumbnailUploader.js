/*global WMU_skipDetails, WMU_show, WMU_openedInEditor */
define( 'views.videopageadmin.thumbnailUpload', [
		'jquery',
		'wikia.window',
		'models.videopageadmin.thumbnail',
		'wikia.aim'
	], function( $, window, ThumbnailModel ) {
	'use strict';

	/*
	 * Creates a ThumbnailUploader view class
	 * @class ThumbnailUploader
	 * @description Built to interop with legacy WikiaMediaUpload extension
	 * @returns Constructor
	 */
	function ThumbnailUploader( opts ) {
		this.$el = opts.el;
		this.$window = $( window );
		this.init();
	}

	ThumbnailUploader.prototype = {
		init: function() {
			this.showUploader();
			// Unbind this later
			this.$window.on( 'WMU_addFromSpecialPage', $.proxy( this.onUserUpload, this ) );
		},
		showUploader: function() {
			// bypass page layout details screen
			// @deprecated WMU global namespace pollution
			window.WMU_skipDetails = true;
			window.WMU_show();
			window.WMU_openedInEditor = false;
		},
		onUserUpload: function( evt, data ) {
			// Unbind events to avoid zombie/duplicate events
			this.$window.off( 'WMU_addFromSpecialPage' );

			var img,
					that = this;

			img = new ThumbnailModel({
					imgTitle: data.imageTitle,
					wikiText: data.imageWikiText
				});

			img.create().done(function( response ) {
					// Swap out the small thumbnail
					that.$el
						.find( '.Wikia-video-thumb' )
						.attr( 'src', response.data.thumbUrl );

					// Swap out the preview link href
					// And fade in the preview link
					that.$el.find( '.preview-large-link' )
						.attr( 'href', response.data.largeThumbUrl )
						.fadeIn( 200 );

					that.$el.find( '.new-thumb' ).val( img.imgTitle );
			});
		}
	};
	return ThumbnailUploader;
});
