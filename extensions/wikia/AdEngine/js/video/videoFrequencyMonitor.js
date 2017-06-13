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

	function parseTime() {
		return [];
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

		return result;
	}

	return {
		registerLaunchedVideo: registerLaunchedVideo,
		videoCanBeLaunched: videoCanBeLaunched
	};
});
