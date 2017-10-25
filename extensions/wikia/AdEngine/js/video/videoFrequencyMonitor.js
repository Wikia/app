/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyMonitor', [
	'ext.wikia.adEngine.video.videoFrequencySettings',
	'ext.wikia.adEngine.video.videoFrequencyStore',
	'wikia.window'
], function (settings, store, win) {
	'use strict';

	function prepareData() {
		return {
			date: new Date().getTime(),
			pv: win.pvNumber
		};
	}

	function registerLaunchedVideo() {
		store.save(prepareData());
	}

	function videoCanBeLaunched() {
		var limits = settings.get(),
			result = true;

		limits.pv.forEach(function (rule) {
			result = result && store.numberOfVideosSeenInLastPageViews(rule.limit) < rule.frequency;
		});

		limits.time.forEach(function (rule) {
			result = result && store.numberOfVideosSeenInTime(rule.limit, rule.unit) < rule.frequency;
		});

		return result;
	}

	return {
		registerLaunchedVideo: registerLaunchedVideo,
		videoCanBeLaunched: videoCanBeLaunched
	};
});
