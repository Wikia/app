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

	function doRequest( params ){
		var qs,
				data,
				trackingLabel;

		// Add loading graphic
		commonAjax.startLoadingGraphic();

		qs = new QueryString();
		data = {
			videoTitle: currTitle,
			sort: qs.getVal( 'sort', 'recent' ),
			currentPage: qs.getVal( 'currentPage', 1 )
		};

		// if @params are explicitly passed through, extend our object with them
		if ( params ) {
			$.extend(data, params);
		}

		trackingLabel = tracker.labels.KEEP;

		if ( isSwap ) {
			data.newTitle = newTitle;
			trackingLabel = tracker.labels.SWAP;
		} else {
			data.suggestions = _getSuggestions();
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
		var currTitleText,
				request;

		request = {};
		currTitleText =  currTitle.replace(/_/g, ' ' );

		// Show confirmation modal only on "Keep"
		$.confirm({
			cancelMsg: $.msg( 'lvs-button-yes' ),
			okMsg: $.msg( 'lvs-button-no' ),
			title: $.msg( 'lvs-confirm-keep-title' ),
			content: $.msg( 'lvs-confirm-keep-message', currTitleText ),
			onOk: function() {
				request.forever = true;
				doRequest( request );
				// Track click on 'no' button
				tracker.track({
					action: tracker.actions.CONFIRM,
					label: tracker.labels.KEEP
				});
			},
			onCancel: function() {
				request.forever = false;
				doRequest( request );

				// track click on 'yes'
				tracker.track({
					action: tracker.actions.CONFIRM,
					label: tracker.labels.KEEP
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

	function _getSuggestions() {
		var arr,
				$suggestions;

		arr = [];
		$suggestions = $row.find( '.more-videos .thumbimage' );

		if ( $suggestions.length ) {
			$suggestions.each(function( idx, elem ) {
					arr.push( $( elem ).data().videoKey );
			});
		} else {
			arr.push(
				$row
					.find( '.premium .video-wrapper .thumbimage' )
					.data().videoKey
			);
		}

		return arr;
	}

	return {
		init: init
	};
});
