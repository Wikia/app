/*exported SlotTracker*/
/*global setTimeout*/
/*jshint camelcase:false, maxparams:5*/

var SlotTracker = function (log, tracker) {
	'use strict';

	var logGroup = 'SlotTracker',
		timeBuckets = [0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.5, 5.0, 8.0],
		timeCheckpoints = [2.0, 5.0, 8.0];

	// The filtering function
	function isInteresting(eventName, data) {
		// Meta-providers
		if (data.provider === 'Null' || data.provider === 'Later') {
			return false;
		}
		// Liftium has its own tracking
		if (data.provider === 'Liftium') {
			return false;
			//eventName === 'register';
		}
		// Flush slots
		if (data.slotname.match(/_FLUSH$/)) {
			return false;
			//eventName === 'register';
		}
		// TOP_BUTTON_WIDE is uninteresting, TOP_BUTTON_WIDE.force is the real thing
		if (data.slotname === 'TOP_BUTTON_WIDE') {
			return false;
		}
		// Don't track state events yet
		if (eventName.match(/^state/)) {
			return false;
		}
		return true;
	}

	function trackEvent(eventName, data, value) {
		var toLog = [
			'event: ' + eventName,
			'provider: ' + data.provider,
			'slotname: ' + data.slotname
		];

		if (eventName.match(/^state/)) {
			toLog.push('state: ' + data.state);
		} else {
			toLog.push('timeBucket: ' + data.timeBucket);
			toLog.push('extraParams');
			toLog.push(data.extraParams);
		}

		toLog.push('value: ' + value);
		toLog.push('interesting: ' + isInteresting(eventName, data) || 'false');

		log(toLog, 'debug', logGroup);
	}

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

	function slotTracker(provider, slotname, source) {
		var timeStart = new Date().getTime(),
			eventsTracked = [],
			lastEventTime,
			i,
			len;

		function trackState(timeCheckPoint) {
			setTimeout(function () {
				trackEvent(
					'state/' + timeCheckPoint + 's',
					{
						provider: provider,
						slotname: slotname,
						state: {eventsTracked: eventsTracked.join(',')}
					},
					lastEventTime
				);
			}, timeCheckPoint * 1000);
		}

		function track(eventName, extraParams) {
			var timeEnd = new Date().getTime(),
				timeElapsed = (timeEnd - timeStart) / 1000,
				timeBucket = getTimeBucket(timeElapsed);

			eventsTracked.push(eventName);
			lastEventTime = timeElapsed;
			trackEvent(
				eventName,
				{
					provider: provider,
					slotname: slotname,
					timeBucket: timeBucket,
					extraParams: extraParams
				},
				timeElapsed
			);
		}

		track('register', {source: source});

		for (i = 0, len = timeCheckpoints.length; i < len; i += 1) {
			trackState(timeCheckpoints[i]);
		}

		return {
			track: track
		};
	}

	return slotTracker;
};
