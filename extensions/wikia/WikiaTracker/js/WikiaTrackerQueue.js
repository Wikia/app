/*global WikiaTracker: true */
var WikiaTrackerQueue = {
	POLL_INTERVAL: 500, // in msec
	POLL_LIMIT: 20,
	pollIntervalId: false,
	pollCounter: 0,

	trackFn: false,

	log: function(msg, obj) {
	},

	// simple replacement for $.proxy in jQuery-free environment
	proxy: function(fn, scope) {
		return function() {
			return fn.apply(scope, arguments);
		};
	},

	init: function() {
	},

	pollBeaconId: function() {
	},

	// move queued items to WikiaTracker
	moveQueue: function() {
	},

	pushCallback: function(item) {
	}
};
