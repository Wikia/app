require( [
	'jquery',
	'lvs.callout',
	'lvs.commonajax',
	'lvs.ellipses',
	'lvs.swapkeep',
	'lvs.undo',
	'lvs.videocontrols',
	'lvs.suggestions',
	'lvs.tracker'
], function( $, callout, commonAjax, ellipses, swapKeep, undo, videoControls, suggestions, tracker ) {

	"use strict";

	$(function() {
		var $container = $( '#LVSGrid' );

		// track impression
		tracker.track({
			action: tracker.actions.IMPRESSION
		});

		callout.init();
		commonAjax.init( $container );
		ellipses.init( $container );
		swapKeep.init( $container );
		undo.init( $container );
		videoControls.init( $container );
		suggestions.init( $container );
	});
});
