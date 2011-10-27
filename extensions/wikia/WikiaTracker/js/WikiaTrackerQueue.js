/*global WikiaTracker: true */
var WikiaTrackerQueue = {

	// check beacon_id every second
	POLL_INTERVAL: 1000,
	pollIntervalId: false,

	trackFn: false,

	init: function() {
		$().log('init', 'wtq');

		// set tracking function - queued items will be passed there
		this.trackFn = $.proxy(WikiaTracker.track, WikiaTracker);

		// check whether beacon_id exists every POLL_INTERVAL ms
		this.pollIntervalId = setInterval($.proxy(this.pollBeaconId, this), this.POLL_INTERVAL);
		this.pollBeaconId();
	},

	pollBeaconId: function() {
		if (typeof window.beacon_id != 'undefined') {
			clearInterval(this.pollIntervalId);

			$().log('beacon_id has arrived', 'wtq');
			this.moveQueue();
		}
		else {
			$().log('beacon_id is not here yet...', 'wtq');
		}
	},

	// move queued items to WikiaTracker
	moveQueue: function() {
		var queue = window._wtq || [],
			item;

		while ((item = queue.shift()) !== undefined) {
			this.pushCallback(item);
		}

		// and now replace _wtq.push with this.pushCallback
		queue.push = $.proxy(this.pushCallback, this);
	},

	pushCallback: function(item) {
		$().log(item, 'wtq.push');

		if (!$.isArray(item)) {
			item = [item];
		}

		this.trackFn.apply(this, item);
	}
};

WikiaTrackerQueue.init();