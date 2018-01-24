/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.adTracker', [
	'ext.wikia.adEngine.utils.timeBuckets',
	'wikia.tracker',
	'wikia.window',
	'wikia.log'
], function (timeBuckets, tracker, win, log) {
	'use strict';

	var buckets = [0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.5, 5.0, 8.0, 20.0, 60.0],
		logGroup = 'ext.wikia.adEngine.adTracker';

	function encodeAsQueryString(extraParams) {
		var out = [], key, keys = [], i, len;

		if (win.ads && win.ads.runtime.pf && typeof win.ads.runtime.pf.blocking === 'boolean') {
			extraParams.pf = win.ads.runtime.pf.blocking ? 'yes' : 'no';
		}

		for (key in extraParams) {
			if (extraParams.hasOwnProperty(key)) {
				keys.push(key);
			}
		}
		keys.sort();
		for (i = 0, len = keys.length; i < len; i += 1) {
			key = keys[i];
			out.push(key + '=' + extraParams[key]);
		}
		return out.join(';');
	}

	/**
	 * A generic function to track an ad-related event and its timing in Google Analytics
	 *
	 * @param {string} eventName - the event name (use slashes for structure)
	 * @param {object} data - extra data to track as JS object (will be converted to URL-like query-string)
	 * @param {number=} value - time in milliseconds (or empty)
	 * @param {string=} forcedLabel - the event label, if empty, the time bucket will be used
	 */
	function track(eventName, data, value, forcedLabel) {
		var category = 'ad/' + eventName,
			action = typeof data === 'string' ? data : encodeAsQueryString(data || {}),
			gaLabel = forcedLabel,
			gaValue,
			trackValue;

		if (!gaLabel) {
			if (value === undefined) {
				gaLabel = '';
				value = 0;
			} else {
				gaLabel = timeBuckets.getTimeBucket(buckets, value / 1000);
				if (/\+$|invalid/.test(gaLabel)) {
					category = category.replace('ad', 'ad/error');
				}
			}
		}

		gaValue = Math.round(value);

		// Empty action is not allowed by Google Analytics, thus:
		action = action || 'nodata';
		trackValue = {
			ga_category: category,
			ga_action: action,
			ga_label: gaLabel,
			ga_value: isNaN(gaValue) ? 0 : gaValue,
			trackingMethod: 'ad'
		};
		tracker.track(trackValue);
		log(trackValue, 'debug', logGroup);
	}

	/**
	 * A generic function to track an ad-related event and its timing in DataWarehouse
	 *
	 * @param {object} data - data to track as JS object (will be converted to URL-like query-string)
	 * @param {string} eventName - part of track URL (https://beacon.wikia-services.com/__track/special/[eventName]?c...)
	 */
	function trackDW(data, eventName) {
		var trackValue = {
			eventName: eventName,
			trackingMethod: 'internal'
		};

		if (typeof data === 'string') {
			trackValue.ping = data;
		} else {
			Object.keys(data).forEach(function (key) {
				trackValue[key] = data[key];
			});
		}
		tracker.track(trackValue);
		log(['trackDW', trackValue], 'debug', logGroup);
	}

	/**
	 * Measure time now. Use the passed event name and data object. Return an object with a track
	 * method. When the method is called, the actual tracking happens. This allows you to separate
	 * the time when the metric is gather from the time the metric is sent to GA
	 *
	 * @param {string} eventName
	 * @param {string|object} eventData
	 * @param {string=} eventType
	 * @returns {{track: Function}}
	 */
	function measureTime(eventName, eventData, eventType) {

		var timingValue = win.wgNow && new Date().getTime() - win.wgNow.getTime();
		eventType = eventType ? '/' + eventType : '';

		return {
			measureDiff: function (diffData, diffType) {
				eventType = '/' + diffType;
				eventData = diffData;
				timingValue = win.wgNow && new Date().getTime() - win.wgNow.getTime() - timingValue;

				return {
					track: this.track
				};
			},
			track: function () {
				if (timingValue) {
					track('timing/' + eventName + eventType, eventData, timingValue);
				}
			}
		};
	}

	return {
		track: track,
		trackDW: trackDW,
		measureTime: measureTime
	};
});
