/**
 * Handle clicks on play buttons so they play the video
 */

define( 'lvs.playvideo', ['wikia.videoBootstrap'], function( VideoBootstrap ) {
	"use strict";

	return function( $container ) {
		var videoWidth = $container.find( '.grid-3' ).first().width();

		$container.on( 'click', '.video', function(e) {
			e.preventDefault();

			var $this = $( this ),
				fileTitle = decodeURIComponent( $this.children( 'img' ).attr( 'data-video-key' )),
				videoInstance,
				$element,
				$thumbList,
				$row = $this.closest( '.row' );

			$row.find( '.swap-button' ).attr( 'data-video-swap', fileTitle );

			if ( $this.hasClass( 'thumb' ) ) {
				// one of the thumbnails was clicked
				$element = $this.closest( '.row' ).find( '.premium .video-wrapper' );
				$thumbList = $this.closest( 'ul' );

				// put outline around the thumbnail that was clicked
				$thumbList.find( '.selected' ).removeClass( 'selected' );
				$this.addClass( 'selected' );
			} else {
				// Large image was clicked
				$element = $this.parent();
			}

			$.nirvana.sendRequest({
				controller: 'VideoHandler',
				method: 'getEmbedCode',
				data: {
					fileTitle: fileTitle,
					width: videoWidth,
					autoplay: 1
				},
				callback: function( data ) {
					videoInstance = new VideoBootstrap( $element[0], data.embedCode, 'licensedVideoSwap' );

					// Update swap button so it contains the dbkey of the video to swap
					$row.find( '.swap-button' ).attr( 'data-video-swap', fileTitle );
				}
			});
		});
	};
});