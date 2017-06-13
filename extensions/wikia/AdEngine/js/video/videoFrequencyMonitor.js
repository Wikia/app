/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyMonitor', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'ext.wikia.adEngine.video.videoFrequencyStore'
], function (adContext, pageViewCounter, store) {
	'use strict';

	var context = adContext.getContext(),
		supportedTimeUnits = ['s', 'sec', 'second', 'seconds',
			'm', 'min', 'minute', 'minutes',
			'h', 'hour', 'hours'
		];

	function prepareData() {
		return {
			date: new Date().getTime(),
			pv: pageViewCounter.get()
		};
	}

	function registerLaunchedVideo() {
		store.save(prepareData());
	}

	function parsePV() {
		if (!context.opts.outstreamVideoFrequencyCapping) {
			return [];
		}

		return context.opts.outstreamVideoFrequencyCapping
			.filter(function (item) {
				return item.indexOf('pv') > -1;
			})
			.map(function (item) {
				var data = item.replace('pv', '').split('/');
				return {
					frequency: parseInt(data[0]),
					limit: parseInt(data[1])
				};
			});
	}

	function guessTimeUnit(txt) {
		var possibleResults = supportedTimeUnits
			.filter(function (unit) {
				return txt.indexOf(unit) > -1;
			});

		return possibleResults.length > 0 ? possibleResults[possibleResults.length - 1] : null;
	}

	function hasTimeUnit(item) {
		return guessTimeUnit(item) !== null;
	}

	 function parseTimeRule(item) {
		var unit = guessTimeUnit(item);
		var data = item.replace(unit, '').split('/');
		return {
			frequency: parseInt(data[0]),
			limit: parseInt(data[1]),
			unit: unit
		};
	}

	function parseTime() {
		if (!context.opts.outstreamVideoFrequencyCapping) {
			return [];
		}

		return context.opts.outstreamVideoFrequencyCapping
			.filter(hasTimeUnit)
			.map(parseTimeRule);
	}

	function parseLimits() {
		return {
			pv: parsePV(),
			time: parseTime()
		};
	}

	function videoCanBeLaunched() {
		var limits = parseLimits(),
			result = true;

		limits.pv.map(function (rule) {
			result = result && store.numberOfVideosSeenInLastPageViews(rule.limit) < rule.frequency;
		});

		limits.time.map(function (rule) {
			result = result && store.numberOfVideosSeenInLast(rule.limit, rule.unit) < rule.frequency;
		});

		return result;
	}

	return {
		registerLaunchedVideo: registerLaunchedVideo,
		videoCanBeLaunched: videoCanBeLaunched
	};
});
