var WikiaTrackerQueue = {

	trackFn: false,

	log: function(msg) {
		$().log(msg, 'wtq');
	},

	init: function() {
		var queue = window._wtq;

		this.log('init');
		this.log(queue);

		// set tracking function - queued items will be passed there
		this.trackFn = $.proxy(WikiaTracker.track, WikiaTracker);

		// move queued items to WikiaTracker
		for (var i=0, len=queue.length; i<len; i++) {
			this.pushCallback(queue[i]);
		}

		// and now replace _wtq.push with this.pushCallback
		queue.push = $.proxy(function(item) {
			this.pushCallback(item);
		}, this);
	},

	pushCallback: function(item) {
		$().log(item, 'wtq.push');

		if (!$.isArray(item)) {
			item = [item];
		}

		this.trackFn.apply(this, item);
	}

};

$(function() {
	WikiaTrackerQueue.init();
});
