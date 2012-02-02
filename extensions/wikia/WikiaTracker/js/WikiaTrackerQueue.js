/*global WikiaTracker: true */
var WikiaTrackerQueue = {
	POLL_INTERVAL: 500, // in msec
	POLL_LIMIT: 20,
	pollIntervalId: false,
	pollCounter: 0,

	trackFn: false,

	log: function(msg, obj) {
		msg = 'wtq: ' + msg;

		if (typeof obj != 'undefined') {
			WikiaTracker.debug(msg, 5, obj);
		}
		else {
			WikiaTracker.debug(msg, 5);
		}
	},

	// simple replacement for $.proxy in jQuery-free environment
	proxy: function(fn, scope) {
		return function() {
			return fn.apply(scope, arguments);
		};
	},

	init: function() {
		window.jQuery && jQuery.internalTrack && jQuery.internalTrack('wtq_init');
		this.log('init');

		// set tracking function - queued items will be passed there
		this.trackFn = this.proxy(WikiaTracker.track, WikiaTracker);

		// check whether beacon_id exists every POLL_INTERVAL ms
		this.pollIntervalId = setInterval(this.proxy(this.pollBeaconId, this), this.POLL_INTERVAL);
		this.pollBeaconId();
	},

	pollBeaconId: function() {
		this.pollCounter++;

		// track the first check for beaconId
		if (this.pollCounter == 1) {
			WikiaTracker._track('/wikiatracker/beacon_total', 'UA-2871474-3', 1);
		}

		if (typeof window.beacon_id != 'undefined' || WikiaTracker.isTracked()) {
			if (this.pollCounter > 1) {
				this.log('beacon_id has arrived');
				WikiaTracker._track('/wikiatracker/beacon_available/' + (this.pollCounter * this.POLL_INTERVAL), 'UA-2871474-3', 1);
			}
			window.jQuery && jQuery.internalTrack && jQuery.internalTrack('wtq_sampled');

			// stop polling
			clearInterval(this.pollIntervalId);

			// move events from wtq to WikiaTracker
			this.moveQueue();
		}
		else {
			this.log('beacon_id is not here yet...');

			// first polling failed
			if (this.pollCounter == 1) {
				WikiaTracker._track('/wikiatracker/beacon_unavailable', 'UA-2871474-3', 1);
			}
		}

		// limit number of polling tries to POLL_LIMIT
		if (this.pollCounter >= this.POLL_LIMIT) {
			window.jQuery && jQuery.internalTrack && jQuery.internalTrack('wtq_nobeacon');
			this.log('limit of ' + this.POLL_LIMIT + ' tries reached');

			clearInterval(this.pollIntervalId);
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
		queue.push = this.proxy(this.pushCallback, this);
	},

	pushCallback: function(item) {
		this.log('push', item);

		if (!(item instanceof Array)) {
			item = [item];
		}

		this.trackFn.apply(this, item);
	}
};

WikiaTrackerQueue.init();
