/* exported AdTracker */
/* jshint camelcase:false */

var AdTracker = function (log, tracker) {
	'use strict';

	var logGroup = 'AdTracker',
		maxTrackedTime = 5;

	function formatTrackTime(t) {
		var formatted;

		log(['formatTrackTime', t], 'debug', logGroup);

		if (isNaN(t)) {
			log(['formatTrackTime', t, 'Error, time tracked is NaN'], 'warning', logGroup);
			return 'NaN';
		}

		if (t < 0) {
			log(['formatTrackTime', t, 'Error, time tracked is a negative number'], 'warning', logGroup);
			return 'negative';
		}

		formatted = t / 1000;
		if (formatted > maxTrackedTime) {
			formatted = 'more_than_' + maxTrackedTime;
			log(['formatTrackTime', t, formatted], 'debug', logGroup);
			return formatted;
		}

		formatted = formatted.toFixed(1);

		log(['formatTrackTime', t, formatted], 'debug', logGroup);
		return formatted;
	}

	function trackInit(provider, slotname, slotsize) {
		log(['trackInit', slotname, slotsize], 'debug', logGroup);

		tracker.track({
			eventName: 'liftium.slot2',
			ga_category: 'slot2/' + slotsize.split(',')[0],
			ga_action: slotname,
			ga_label: provider,
			trackingMethod: 'ad'
		});
	}

	function trackEnd(provider, category, slotname, hopTime) {
		log(['trackEnd', category, slotname, hopTime], 'debug', logGroup);

		tracker.track({
			eventName: 'liftium.hop2',
			ga_category: category + '2/' + provider,
			ga_action: 'slot ' + slotname,
			ga_label: formatTrackTime(hopTime),
			trackingMethod: 'ad'
		});
	}

	function trackSlot(provider, slotname, slotsize) {
		var slotStart;

		return {
			init: function () {
				slotStart = new Date().getTime();
				trackInit(provider, slotname, slotsize);
			},
			success: function () {
				var slotEnd = new Date().getTime();
				if (!slotStart) {
					throw 'AdTracker: call init before success';
				}
				trackEnd(provider, 'success', slotname, slotEnd - slotStart);
			},
			hop: function () {
				var slotEnd = new Date().getTime();
				if (!slotStart) {
					throw 'AdTracker: call init before hop';
				}
				trackEnd(provider, 'hop', slotname, slotEnd - slotStart);
			}
		};
	}

	return {
		trackSlot: trackSlot
	};
};
