/**
 * These are generic functions having to do with loading graphics
 * and ajax responses for LVS
 */
define( 'lvs.commonajax', ['wikia.window', 'lvs.tracker'], function( window, tracker ) {
	"use strict";

	var $body,
		$container;

	function init( $elem ) {
		$body = $( 'body' );
		$container = $elem;
	};

	// add loading graphic
	function startLoadingGraphic() {
		var scrollTop = $( window ).scrollTop();
		$body.addClass( 'lvs-loading' ).startThrobbing();
		$body.children( '.wikiaThrobber' ).css( 'top', scrollTop );
	}

	// remove loading graphic
	function stopLoadingGraphic() {
		$body.removeClass( 'lvs-loading' ).stopThrobbing();
	}

	// ajax success callback
	function success( data, trackingLabel ) {
		if( data.result == 'error' ) {
			window.GlobalNotification.show( data.msg, 'error' );
			stopLoadingGraphic();
		} else {
			window.GlobalNotification.show( data.msg, 'confirm' );
			// update the grid and trigger the reset event for JS garbage collection
			$container.html( data.html ).trigger( 'contentReset' );
			stopLoadingGraphic();

			tracker.track({
				action: tracker.actions.SUCCESS,
				label: trackingLabel
			});
		}
	}

	// ajax failure callback
	function failure() {
		stopLoadingGraphic();
	}

	return {
		init: init,
		startLoadingGraphic: startLoadingGraphic,
		success: success,
		failure: failure
	}
});