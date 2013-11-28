/*exported SlotTracker*/
/*global setTimeout*/
/*jshint camelcase:false, maxparams:5*/

var SlotTracker = function (log) {
	'use strict';

	var logGroup = 'SlotTracker',
		timeBuckets = [0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.5, 5.0, 8.0],
		timeCheckpoints = [2.0, 5.0, 8.0];

	function getTimeBucket(time) {
		var i,
			len = timeBuckets.length,
			bucket;

		for (i = 0; i < len; i += 1) {
			if (time >= timeBuckets[i]) {
				bucket = i;
			}
		}

		if (bucket === len - 1) {
			return timeBuckets[bucket] + '-';
		}

		if (bucket >= 0) {
			return timeBuckets[bucket] + '-' + timeBuckets[bucket + 1];
		}

		return 'invalid';
	}

	function slotTracker(provider, slotname) {
		var timeStart = new Date().getTime(),
			eventsTracked = [],
			lastEventTime,
			i,
			len;

		function trackState(timeCheckPoint) {
			setTimeout(function () {
				log([
					'state',
					provider,
					slotname,
					timeCheckPoint + 's',
					eventsTracked.join(','),
					'value: ' + lastEventTime
				], 'debug', logGroup);
			}, timeCheckPoint * 1000);
		}

		function track(eventName, extraParams) {
			var timeEnd = new Date().getTime(),
				timeElapsed = (timeEnd - timeStart) / 1000,
				timeBucket = getTimeBucket(timeElapsed);

			eventsTracked.push(eventName);
			lastEventTime = timeElapsed || lastEventTime;
			log([
				'event: ' + eventName,
				'provider: ' + provider,
				'slotname: ' + slotname,
				'timeBucket: ' + timeBucket,
				'extraParams: ', extraParams,
				'value: ' + timeElapsed
			], 'debug', logGroup);
		}

		track('register');

		for (i = 0, len = timeCheckpoints.length; i < len; i += 1) {
			trackState(timeCheckpoints[i]);
		}

		return {
			track: track
		};
	}

	return slotTracker;
};
