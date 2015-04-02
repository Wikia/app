define('lvs.tracker', ['wikia.tracker'], function (tracker) {

	'use strict';

	// LVS constants
	return {
		track: tracker.buildTrackingFunction({
			category: 'lvs',
			trackingMethod: 'analytics',
			value: 0
		}),
		labels: {
			KEEP: 'keep',
			SWAP: 'swap',
			UNDO: 'undo',
			PREMIUM: 'premium',
			NON_PREMIUM: 'non-premium',
			SUGGESTIONS: 'more-suggestions'
		},
		actions: {
			PLAY: tracker.ACTIONS.PLAY_VIDEO,
			SUCCESS: tracker.ACTIONS.SUCCESS,
			CLICK: tracker.ACTIONS.CLICK,
			CONFIRM: tracker.ACTIONS.CONFIRM,
			IMPRESSION: tracker.ACTIONS.IMPRESSION
		}
	};

});
