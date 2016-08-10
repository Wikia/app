/*global setTimeout, define*/
/*jshint camelcase:false, maxparams:5*/

define('ext.wikia.adEngine.slotTracker', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker'
], function (adContext, adTracker) {
	'use strict';

	var timeCheckpoints = [2.0, 5.0, 8.0, 20.0],
		context = adContext.getContext(),
		stats = {
			allEvents: 0,
			interestingEvents: 0
		},
		slotTypes = {
			CORP_TOP_LEADERBOARD:   'leaderboard',
			CORP_TOP_RIGHT_BOXAD:   'medrec',
			EXIT_STITIAL_BOXAD_1:   'medrec',
			HOME_TOP_LEADERBOARD:   'leaderboard',
			HOME_TOP_RIGHT_BOXAD:   'medrec',
			HUB_TOP_LEADERBOARD:    'leaderboard',
			INCONTENT_BOXAD_1:      'medrec',
			INCONTENT_LEADERBOARD:  'incontent',
			INVISIBLE_SKIN:         'pixel',
			LEFT_SKYSCRAPER_2:      'skyscraper',
			LEFT_SKYSCRAPER_3:      'skyscraper',
			MOBILE_IN_CONTENT:      'mobile_content',
			MOBILE_PREFOOTER:       'mobile_prefooter',
			MOBILE_TOP_LEADERBOARD: 'mobile_leaderboard',
			MODAL_INTERSTITIAL:     'interstitial',
			MODAL_INTERSTITIAL_1:   'interstitial',
			MODAL_INTERSTITIAL_2:   'interstitial',
			MODAL_INTERSTITIAL_3:   'interstitial',
			MODAL_INTERSTITIAL_4:   'interstitial',
			MODAL_INTERSTITIAL_5:   'interstitial',
			PREFOOTER_LEFT_BOXAD:   'prefooter',
			PREFOOTER_MIDDLE_BOXAD: 'prefooter',
			PREFOOTER_RIGHT_BOXAD:  'prefooter',
			TOP_LEADERBOARD:        'leaderboard',
			TOP_RIGHT_BOXAD:        'medrec'
		};

	// The filtering function
	function isInteresting(eventName, data) {
		// Meta-providers
		if (data.provider === 'Null' || data.provider === 'Later') {
			return false;
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
		if (!context.opts.trackSlotState && eventName.match(/^state/)) {
			return false;
		}

		return true;
	}

	function trackEvent(eventName, data, value) {
		var slotname = data.slotname,
			slotType = slotTypes[slotname] || 'other',
			extraParams = data.extraParams || {},
			forcedLabel = data.state;

		extraParams.pos = data.slotname;

		stats.allEvents += 1;
		if (isInteresting(eventName, data)) {
			stats.interestingEvents += 1;
			adTracker.track(
				[eventName, data.provider, slotType].join('/'),
				extraParams,
				value,
				forcedLabel
			);
		}
	}

	function slotTracker(provider, slotname, source) {
		var timeStart = new Date().getTime(),
			eventsTracked = [],
			lastEventTime,
			i,
			len;

		function trackState(timeCheckPoint) {
			var eventName = 'state/' + timeCheckPoint + 's';

			setTimeout(function () {
				trackEvent(
					eventName,
					{
						provider: provider,
						slotname: slotname,
						state: eventsTracked.join(',')
					},
					lastEventTime * 1000
				);
			}, timeCheckPoint * 1000);
		}

		function track(eventName, extraParams) {
			var timeEnd = new Date().getTime(),
				timeElapsed = (timeEnd - timeStart) / 1000;

			eventsTracked.push(eventName);
			lastEventTime = timeElapsed;

			trackEvent(
				eventName,
				{
					provider: provider,
					slotname: slotname,
					extraParams: extraParams
				},
				timeElapsed * 1000
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

	function getStats() {
		return stats;
	}

	slotTracker.getStats = getStats;

	return slotTracker;
});
