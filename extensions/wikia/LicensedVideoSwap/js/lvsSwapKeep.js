
define( 'lvs.swapkeep', ['lvs.containerdom'], function( containerDOM ) {
	"use strict";

	return function( $container ) {
		var $loading = $('<div class="loading-bg"></div>' ),
			$parent,
			$overlay,
			$row,
			$button,
			isSwap,
			currTitle,
			newTitle;

		function doRequest(){
			// Add loading graphic
			$loading.appendTo( $container );
			$overlay.addClass( 'loading' ).show();

			var data = {
				videoTitle: currTitle,
				sort: 'recent', // TODO: make this dynamic
				currentPage: 1 // TODO: make this dynamic
			};

			if ( isSwap ) {
				data.newTitle = newTitle;
			}

			$.nirvana.sendRequest({
				controller: 'LicensedVideoSwapSpecialController',
				method: isSwap ? 'swapVideo' : 'keepVideo',
				data: data,
				callback: function( data ) {
					containerDOM( $container, data);
				}
			});
		}

		function confirmModal() {
			var currTitleText =  currTitle.replace(/_/g, ' ' ),
				newTitleText,
				title,
				msg;

			if ( isSwap ) {
				newTitleText = newTitle.replace(/_/g, ' ' );
				title = $.msg( 'lvs-confirm-swap-title' );
				msg = $.msg( 'lvs-confirm-swap-message', currTitleText, newTitleText );
			} else {
				title = $.msg( 'lvs-confirm-keep-title' );
				msg = $.msg( 'lvs-confirm-keep-message', currTitleText );
			}

			$.confirm({
				title: title,
				content: msg,
				onOk: function() {
					doRequest();
				},
				width: 700
			});
		}

		// Event listener for interacting with buttons
		$container.on( 'mouseover mouseout click', '.swap-button, .keep-button', function( e ) {
			$button = $( this );

			$parent = $button.parent();
			$overlay = $parent.siblings( '.swap-arrow' );
			$row = $button.closest( '.row' );
			isSwap = $button.is( '.swap-button' );

			if ( isSwap ) {
				// swap button hovered
				if ( e.type == 'mouseover' ) {
					$overlay.fadeIn( 100 );
				} else if ( e.type == 'mouseout' ) {
					$overlay.fadeOut( 100 );
					// swap button clicked
				} else if ( e.type == 'click' ) {
					// Get both titles - current/non-premium video and video to swap it out with
					newTitle = decodeURIComponent( $button.attr( 'data-video-swap' ) );
					currTitle = decodeURIComponent( $row.find( '.keep-button' ).attr( 'data-video-keep' ) );
					confirmModal();
				}
				// Keep button clicked
			} else if ( e.type == 'click' ) {
				currTitle = decodeURIComponent( $row.find( '.keep-button' ).attr( 'data-video-keep' ) );
				// no new title b/c we're keeping the current video
				newTitle = '';
				confirmModal();
			}
		});
	};
});