/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyMonitor', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'ext.wikia.adEngine.video.videoFrequencyStore'
], function (adContext, pageViewCounter, store) {
	'use strict';

	var context = adContext.getContext();

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

	function hasTimeUnit(item) {
		return item.indexOf('min') > -1; // TODO add support for all time units
	}

	function parseTime() {
		if (!context.opts.outstreamVideoFrequencyCapping) {
			return [];
		}

		return context.opts.outstreamVideoFrequencyCapping
			.filter(hasTimeUnit)
			.map(function (item) {
				var data = item.replace('min', '').split('/'); // TODO replace with others time units
				return {
					frequency: parseInt(data[0]),
					limit: parseInt(data[1]),
					unit: 'min'
				};
			});
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
