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
	'use strict';

	var $parent,
		$overlay,
		$row,
		$button,
		$container,
		$keepButton,
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
				currentPage: qs.getVal( 'currentPage', 1 )
			},
			trackingLabel = tracker.labels.KEEP;

		if ( isSwap ) {
			data.newTitle = newTitle;
			trackingLabel = tracker.labels.SWAP;
		}

		nirvana.sendRequest({
			controller: 'LicensedVideoSwapSpecialController',
			method: isSwap ? 'swapVideo' : 'keepVideo',
			data: data,
			callback: function( data ) {
				commonAjax.success( data, trackingLabel );
			},
			onErrorCallback: function() {
				commonAjax.failure();
			}
		});
	}

	function confirmModal() {
		videoControls.reset();
		var currTitleText =  currTitle.replace(/_/g, ' ' );
		// Show confirmation modal only on "Keep"
		$.confirm({
			cancelMsg: $.msg( 'lvs-button-yes' ),
			okMsg: $.msg( 'lvs-button-no' ),
			title: $.msg( 'lvs-confirm-keep-title' ),
			content: $.msg( 'lvs-confirm-keep-message', currTitleText ),
			onOk: function() {
				doRequest();
				// Track click on okay button
				tracker.track({
					action: tracker.actions.CONFIRM,
					label: isSwap ? tracker.labels.SWAP : tracker.labels.KEEP
				});
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
			$keepButton = $row.find( '.keep-button' );
			isSwap = $button.is( '.swap-button' );

			if ( isSwap ) {
				// swap button hovered
				if ( e.type === 'mouseover' ) {
					$overlay.fadeIn( 100 );
				} else if ( e.type === 'mouseout' ) {
					$overlay.fadeOut( 100 );
					// swap button clicked
				} else if ( e.type === 'click' ) {
					// Get both titles - current/non-premium video and video to swap it out with
					newTitle = decodeURIComponent( $button.attr( 'data-video-swap' ) );
					currTitle = decodeURIComponent( $keepButton.attr( 'data-video-keep' ) );
					doRequest();

					// Track click action
					tracker.track({
						action: tracker.actions.CLICK,
						label: tracker.labels.SWAP
					});
				}
				// Keep button clicked
			} else if ( e.type === 'click' ) {

				// Track click actions
				tracker.track({
					action: tracker.actions.CLICK,
					label: tracker.labels.KEEP
				});

				currTitle = decodeURIComponent( $keepButton.attr( 'data-video-keep' ) );
				// no new title b/c we're keeping the current video
				newTitle = '';
				
				if ( $keepButton.data( 'subsequent-keep' ) ) {

					confirmModal();

				} else {

					doRequest();

					videoControls.reset();

					tracker.track({
						action: tracker.actions.CONFIRM,
						label: tracker.labels.KEEP
					});
				}
			}
		});
	}

	return {
		init: init
	};
});
