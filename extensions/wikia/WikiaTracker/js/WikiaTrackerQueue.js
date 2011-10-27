/*global WikiaTracker: true */
var WikiaTrackerQueue = {

	// check beacon_id every second
	POLL_INTERVAL: 1000,
	POLL_LIMIT: 30,
	pollIntervalId: false,
	pollCounter: 0,

	trackFn: false,

	log: function(msg) {
		$().log(msg, 'wtq');
	},

	init: function() {
		this.log('init');

		// set tracking function - queued items will be passed there
		this.trackFn = $.proxy(WikiaTracker.track, WikiaTracker);

		// check whether beacon_id exists every POLL_INTERVAL ms
		this.pollIntervalId = setInterval($.proxy(this.pollBeaconId, this), this.POLL_INTERVAL);
		this.pollBeaconId();
	},

	pollBeaconId: function() {
		this.pollCounter++;

		// track the first check for beaconId
		if (this.pollCounter == 1) {
			this.trackBeacon('total');
		}

		if (typeof window.beacon_id != 'undefined') {
			this.log('beacon_id has arrived');
			this.trackBeacon('available/' + this.pollCounter);

			// stop polling
			clearInterval(this.pollIntervalId);

			// move events from wtq to WikiaTracker
			this.moveQueue();
		}
		else {
			this.log('beacon_id is not here yet...');

			// first polling failed
			if (this.pollCounter == 1) {
				this.trackBeacon('unavailable');
			}
		}

		// limit number of polling tries to POLL_LIMIT
		if (this.pollCounter >= this.POLL_LIMIT) {
			this.log('limit of ' + this.POLL_LIMIT + ' tries reached');
			this.trackBeacon('timeout');

			clearInterval(this.pollIntervalId);
		}
	},

	trackBeacon: function(ev) {
		WikiaTracker._track('/wikiatracker/beacon_' + ev, 'UA-2871474-3', 1);
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