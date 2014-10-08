/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.adTracker', ['wikia.tracker', 'wikia.window'], function (tracker, window) {
	'use strict';

	var timeBuckets = [0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.5, 5.0, 8.0, 20.0, 60.0];

	function encodeAsQueryString(extraParams) {
		var out = [], key;
		for (key in extraParams) {
			if (extraParams.hasOwnProperty(key)) {
				out.push(key + '=' + extraParams[key]);
			}
		}
		return out.join(';');
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
			return timeBuckets[bucket] + '+';
		}

		if (bucket >= 0) {
			return timeBuckets[bucket] + '-' + timeBuckets[bucket + 1];
		}

		return 'invalid';
	}

	/**
	 * A generic function to track an ad-related event and its timing
	 *
	 * @param eventName: the event name (use slashes for structure)
	 * @param data: extra data to track as JS object (will be converted to URL-like query-string)
	 * @param value: time in milliseconds (or empty)
	 * @param forcedLabel: the event label, if empty, the time bucket will be used
	 */
	function track(eventName, data, value, forcedLabel) {
		var category = 'ad/' + eventName,
			action = encodeAsQueryString(data || {}),
			gaLabel = forcedLabel,
			gaValue;

		if (!gaLabel) {
			if (value === undefined) {
				gaLabel = '';
				value = 0;
			} else {
				gaLabel = getTimeBucket(value / 1000);
				if (/\+$|invalid/.test(gaLabel)) {
					category = category.replace('ad', 'ad/error');
				}
			}
		}

		gaValue = Math.round(value);

		tracker.track({
			ga_category: category,
			ga_action: action,
			ga_label: gaLabel,
			ga_value: isNaN(gaValue) ? 0 : gaValue,
			trackingMethod: 'ad'
		});
	}

	/**
	 * Measure time now. Use the passed event name and data object. Return an object with a track
	 * method. When the method is called, the actual tracking happens. This allows you to separate
	 * the time when the metric is gather from the time the metric is sent to GA
	 *
	 * @param eventName: String
	 * @param data: Object
	 * @returns {{track: Function}}
	 */
	function measureTime(eventName, data) {
		var timeWgNowBased = window.wgNow && new Date().getTime() - window.wgNow.getTime(),
			performance = window.performance,
			timePerformanceBased = performance && performance.now && Math.round(performance.now());

		return {
			track: function () {
				if (timeWgNowBased) {
					track('timing/' + eventName + '/wgNow', data, timeWgNowBased);
				}
				if (timePerformanceBased) {
					track('timing/' + eventName + '/performance', data, timePerformanceBased);
				}
			}
		};
	}

	return {
		track: track,
		measureTime: measureTime
	};
});
