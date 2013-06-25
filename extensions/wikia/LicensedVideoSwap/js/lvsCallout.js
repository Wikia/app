/**
 * This function controlls the callout box at the top of the page.
 * When the "x" is clicked, a local storage entry is set so the
 * callout won't show again.
 */
define( 'lvs.callout', ['wikia.localStorage', 'jquery'], function( LocalStorage, $ ) {
	"use strict";

	function init() {

		var $callout = $( '#WikiaArticle' ).find( '.lvs-callout' ),
			$closeBtn = $callout.find( '.close' );

		if ( !LocalStorage.lvsCalloutClosed ) {
			$callout.show();

			$closeBtn.on( 'click', function( e ) {
				e.preventDefault();
				$callout.slideUp();
				LocalStorage.lvsCalloutClosed = true;
			});
		}
	}

	return {
		init: init
	};
});
