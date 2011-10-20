/*global WikiaTracker: true */
var WikiaTrackerQueue = {

	trackFn: false,

	init: function() {
		var queue = window._wtq || [],
			item;

		// set tracking function - queued items will be passed there
		this.trackFn = $.proxy(WikiaTracker.track, WikiaTracker);

		// move queued items to WikiaTracker
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

$(function() {
	WikiaTrackerQueue.init();
});
