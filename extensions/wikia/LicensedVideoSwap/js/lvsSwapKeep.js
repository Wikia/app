/**
 * Controls for swap button and keep button in LicensedVideoSwap
 */
define( 'lvs.swapkeep', [
	'wikia.querystring',
	'lvs.commonajax',
	'lvs.videocontrols',
	'jquery',
	'wikia.nirvana',
	'lvs.tracker'
], function( QueryString, commonAjax, videoControls, $, nirvana, tracker ) {
	"use strict";

	var $parent,
		$overlay,
		$row,
		$button,
		$container,
		isSwap,
		currTitle,
		newTitle;

	function doRequest(){
		// Add loading graphic
		commonAjax.startLoadingGraphic();

		var qs = new QueryString(),
			data = {
				videoTitle: currTitle,
				sort: qs.getVal( 'sort', 'recent' ),
				currentPage: qs.getVal( 'currentPage', 1)
			},
			trackingLabel = tracker.KEEP;

		if ( isSwap ) {
			data.newTitle = newTitle;
			trackingLabel = tracker.SWAP;
		}

		nirvana.sendRequest({
			controller: 'LicensedVideoSwapSpecialController',
			method: isSwap ? 'swapVideo' : 'keepVideo',
			data: data,
			callback: function( data ) {
				commonAjax.success( data, trackingLabel);
			},
			onErrorCallback: function() {
				commonAjax.failure();
			}
		});
	}

	function confirmModal() {
		videoControls.reset();

		var currTitleText =  currTitle.replace(/_/g, ' ' ),
			newTitleText,
			title,
			msg;

		if ( isSwap ) {
			newTitleText = newTitle.replace(/_/g, ' ' );
			title = $.msg( 'lvs-confirm-swap-title' );
			if ( currTitleText == newTitleText ) {
				msg = $.msg( 'lvs-confirm-swap-message-same-title', currTitleText );
			} else {
				msg = $.msg( 'lvs-confirm-swap-message-different-title', currTitleText, newTitleText );
			}
		} else {
			title = $.msg( 'lvs-confirm-keep-title' );
			msg = $.msg( 'lvs-confirm-keep-message', currTitleText );
		}

		$.confirm({
			title: title,
			content: msg,
			onOk: function() {
				doRequest();

				// Track click on okay button
				tracker.track( {
					action: tracker.CONFIRM,
					label: isSwap ? tracker.SWAP : tracker.KEEP
				} );

			},
			width: 700
		});
	}

	function init( $elem ) {
		$container = $elem;

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

					// Track click action
					tracker.track( {
						action: tracker.CLICK,
						label: tracker.SWAP
					} );
				}
				// Keep button clicked
			} else if ( e.type == 'click' ) {
				currTitle = decodeURIComponent( $row.find( '.keep-button' ).attr( 'data-video-keep' ) );
				// no new title b/c we're keeping the current video
				newTitle = '';
				confirmModal();

				// Track click action
				tracker.track( {
					action: tracker.CLICK,
					label: tracker.KEEP
				} );
			}
		});
	}

	return {
		init: init
	};
});