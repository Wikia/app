/*global WMU_skipDetails, WMU_show, WMU_openedInEditor */
define( 'views.videopageadmin.thumbnailupload', [
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
			window.WMU_exactHeight = 461;
			window.WMU_exactWidth = 1024;
			window.WMU_aspectRatio = 1024/461;
			window.WMU_skipDetails = true;
			window.WMU_show();
			window.WMU_openedInEditor = false;
		},
		onUserUpload: function( evt, data ) {
			evt.preventDefault();
			// Unbind events to avoid zombie/duplicate events
			this.$window.off( 'WMU_addFromSpecialPage' );

			var img,
				that = this,
				$videoThumb;

			img = new ThumbnailModel({
				imgTitle: data.imageTitle,
				wikiText: data.imageWikiText
			});

			$videoThumb = this.$el.find('.video-thumb');

			img.create().done(function( response ) {

				// Swap out the small thumbnail
				if ( $videoThumb.find('img').length ) {
					that.$el
						.find( '.Wikia-video-thumb' )
						.attr( 'src', response.data.thumbUrl );

				} else {
					$videoThumb.html( $('<img>' )
						.addClass( 'Wikia-video-thumb' )
						.attr( 'src', response.data.thumbUrl ) );
				}

				// Swap out the preview link href
				// And fade in the preview link
				that.$el.find( '.preview-large-link' )
					.attr( 'href', response.data.largeThumbUrl )
					.fadeIn( 200 );

				that.$el.find( '.alt-thumb' ).val( response.data.imageKey );
				that.$el.find( '.alt-thumb-name' ).text( response.data.imageTitle );

			});
		}
	};
	return ThumbnailUploader;
});
