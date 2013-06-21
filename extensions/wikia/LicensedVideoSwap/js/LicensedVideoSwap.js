require( [
	'jquery',
	'lvs.callout',
	'lvs.dropdown',
	'lvs.ellipses',
	'lvs.swapkeep',
	'lvs.undo',
	'lvs.videocontrols',
	'lvs.suggestions'
], function( $, callout, dropdown, ellipses, swapkeep, undo, videoControls, suggestions ) {

	"use strict";

	$(function() {
		var $container = $( '#LVSGrid' );

		callout.init();
		dropdown.init();
		ellipses.init( $container );
		swapkeep.init( $container );
		undo.init( $container );
		videoControls.init( $container );
		suggestions.init( $container );
	});
});
