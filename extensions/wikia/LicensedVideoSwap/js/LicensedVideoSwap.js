require( [
	'jquery',
	'lvs.callout',
	'lvs.commonajax',
	'lvs.dropdown',
	'lvs.ellipses',
	'lvs.swapkeep',
	'lvs.undo',
	'lvs.videocontrols',
	'lvs.suggestions'
], function( $, callout, commonAjax, dropdown, ellipses, swapKeep, undo, videoControls, suggestions ) {

	"use strict";

	$(function() {
		var $container = $( '#LVSGrid' );

		callout.init();
		dropdown.init();
		commonAjax.init( $container );
		ellipses.init( $container );
		swapKeep.init( $container );
		undo.init( $container );
		videoControls.init( $container );
		suggestions.init( $container );
	});
});
