/*exported SlotTracker*/
/*global setTimeout*/
/*jshint camelcase:false, maxparams:5*/
/*global define*/

var SlotTracker = function (log, tracker) {
	'use strict';

	var logGroup = 'SlotTracker',
		timeBuckets = [0.0, 0.5, 1.0, 1.5, 2.0, 2.5, 3.5, 5.0, 8.0, 20.0, 60.0],
		timeCheckpoints = [2.0, 5.0, 8.0, 20.0],
		stats = {
			allEvents: 0,
			interestingEvents: 0
		},
		slotTypes = {
			CORP_TOP_LEADERBOARD:  'leaderboard',
			HOME_TOP_LEADERBOARD:  'leaderboard',
			HUB_TOP_LEADERBOARD:   'leaderboard',
			TOP_LEADERBOARD:       'leaderboard',
			CORP_TOP_RIGHT_BOXAD:  'medrec',
			EXIT_STITIAL_BOXAD_1:  'medrec',
			HOME_TOP_RIGHT_BOXAD:  'medrec',
			INCONTENT_BOXAD_1:     'medrec',
			TOP_RIGHT_BOXAD:       'medrec',
			MODAL_INTERSTITIAL:    'interstitial',
			MODAL_INTERSTITIAL_1:  'interstitial',
			MODAL_INTERSTITIAL_2:  'interstitial',
			MODAL_INTERSTITIAL_3:  'interstitial',
			MODAL_INTERSTITIAL_4:  'interstitial',
			INVISIBLE_1:           'pixel',
			INVISIBLE_2:           'pixel',
			INVISIBLE_SKIN:        'pixel',
			LEFT_SKYSCRAPER_2:     'skyscraper',
			LEFT_SKYSCRAPER_3:     'skyscraper',
			PREFOOTER_LEFT_BOXAD:  'prefooter',
			PREFOOTER_RIGHT_BOXAD: 'prefooter',
			TOP_BUTTON_WIDE:       'button',
			WIKIA_BAR_BOXAD_1:     'wikiabar'
		};

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

	function buildExtraParamsString(extraParams) {
		var out = [], key;
		for (key in extraParams) {
			out.push(key + '=' + extraParams[key]);
		}
		return out.join(';');
	}

	function trackEvent(eventName, data, value) {
		var interesting = isInteresting(eventName, data),
			slotname = data.slotname,
			slotType = slotTypes[slotname] || 'other',
			extraParams = data.extraParams || {},
			gaCategory,
			gaAction,
			gaLabel,
			gaValue;

		extraParams.pos = data.slotname;

		gaCategory = ['ad', eventName, data.provider, slotType].join('/');
		gaAction = buildExtraParamsString(extraParams);
		gaLabel = data.state || data.timeBucket || 0;
		gaValue = value;

		stats.allEvents += 1;
		if (interesting) {
			stats.interestingEvents += 1;

			if (window.wgAdDriverUseNewTracking) {
				log(['Pushing to GA', gaCategory, gaAction, gaLabel, gaValue], 'info', logGroup);

				tracker.track({
					ga_category: gaCategory,
					ga_action: gaAction,
					ga_label: gaLabel,
					ga_value: Math.round(gaValue),
					trackingMethod: 'ad'
				});
			} else {
				log(['Not pushing to GA (wgAdDriverUseNewTracking is false)',
					gaCategory, gaAction, gaLabel, gaValue], 'debug', logGroup
				);
			}
		} else {
			log(['Not pushing to GA (not interesting)',
				gaCategory, gaAction, gaLabel, gaValue], 'debug', logGroup
			);
		}
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
						state: eventsTracked.join(',')
					},
					lastEventTime * 1000
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
};

define('ext.wikia.adengine.slottracker', ['wikia.log', 'wikia.tracker'], SlotTracker);
