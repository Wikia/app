define( 'lvs.tracker', [ 'wikia.tracker' ], function( tracker ) {

	"use strict";

	// LVS constants.  Note: we may want to make this its own module.
	return {
		track: Wikia.Tracker.buildTrackingFunction({
			category: 'lvs',
			trackingMethod: 'ga',
			value: 0
		}),
		KEEP: 'keep',
		SWAP: 'swap',
		UNDO: 'undo',
		PLAY: 'play-video',
		SUCCESS: 'success',
		CLICK: 'click',
		PREMIUM: 'premium',
		NON_PREMIUM: 'non-premium',
		SUGGESTIONS: 'more-suggestions'
	};

} );