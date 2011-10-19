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
	},

	pushCallback: function() {
		$().log(arguments, 'wtq.push');
		this.trackFn.call(this, arguments);
	}

};

$(function() {
	WikiaTrackerQueue.init();
});
