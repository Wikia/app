require( [
	'jquery',
	'lvs.callout',
	'lvs.dropdown',
	'lvs.ellipses',
	'lvs.swapkeep',
	'lvs.undo',
	'lvs.playvideo',
	'lvs.suggestions'
], function( $, callout, dropdown, ellipses, swapkeep, undo, playvideo, suggestions ) {

	"use strict";

	$(function() {
		var $container = $( '#LVSGrid' );

		callout();
		dropdown();
		ellipses( $container );
		swapkeep( $container );
		undo( $container );
		playvideo( $container );
		suggestions( $container );
	});
});
