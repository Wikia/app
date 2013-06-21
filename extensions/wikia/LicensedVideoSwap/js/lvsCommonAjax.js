/**
 * These are generic functions having to do with loading graphics
 * and ajax responses for LVS
 */
define( 'lvs.commonajax', ['wikia.window'], function( window ) {
	"use strict";

	var $body;

	$(function() {
		$body = $( 'body' );
	});

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
	function success( $container, data ) {
		if( data.result == 'error' ) {
			window.GlobalNotification.show( data.msg, 'error' );
			stopLoadingGraphic();
		} else {
			window.GlobalNotification.show( data.msg, 'confirm' );
			// update the grid and trigger the reset event for JS garbage collection
			$container.html( data.html ).trigger( 'contentReset' );
			stopLoadingGraphic();
		}
	}

	// ajax failure callback
	function failure() {
		stopLoadingGraphic();
	}

	return {
		startLoadingGraphic: startLoadingGraphic,
		success: success,
		failure: failure
	}
});