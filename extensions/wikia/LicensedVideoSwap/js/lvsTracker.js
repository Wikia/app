define( 'lvs.tracker', [ 'wikia.tracker' ], function( tracker ) {

	"use strict";

	// LVS constants.  Note: we may want to make this its own module.
	return {
		track: tracker.buildTrackingFunction({
			category: 'lvs',
			trackingMethod: 'ga',
			value: 0
		}),
		KEEP: 'keep',
		SWAP: 'swap',
		UNDO: 'undo',
		PREMIUM: 'premium',
		NON_PREMIUM: 'non-premium',
		SUGGESTIONS: 'more-suggestions',
		PLAY: tracker.ACTIONS.PLAY_VIDEO,
		SUCCESS: tracker.ACTIONS.SUCCESS,
		CLICK: tracker.ACTIONS.CLICK,
		CONFIRM: tracker.ACTIONS.CONFIRM
	};

} );