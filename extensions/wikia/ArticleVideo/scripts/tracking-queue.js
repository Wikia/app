define('wikia.articleVideo.trackingQueue', ['wikia.tracker'], function (tracker) {
	function TrackingQueue(options) {
		this.onHold = false;
		this.queue = [];
		this.realTrack = tracker.buildTrackingFunction(options);
	}

	TrackingQueue.prototype.track = function (trackingData) {
		if (this.onHold) {
			this.queue.push(trackingData);
		} else {
			this.realTrack(trackingData);
		}
	};

	TrackingQueue.prototype.hold = function () {
		this.onHold = true;
	};

	TrackingQueue.prototype.release = function () {
		var trackingData;
		while (trackingData = this.queue.shift()) {
			this.realTrack(trackingData);
		}
		this.onHold = false;
	};

	return TrackingQueue;
});
