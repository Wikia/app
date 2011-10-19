var WikiaTrackerQueue = {

	log: function(msg) {
		$().log(msg, 'wtq');
	},

	init: function() {
		this.log('init');
		this.log(window._wtq);
	}

};

$(function() {
	WikiaTrackerQueue.init();
});
