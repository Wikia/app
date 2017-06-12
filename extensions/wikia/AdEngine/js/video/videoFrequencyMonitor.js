/*global define*/
define('ext.wikia.adEngine.video.videoFrequencyMonitor', [
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'ext.wikia.adEngine.video.videoFrequencyStore'
], function (pageViewCounter, store) {
	'use strict';

	function prepareData() {
		return {
			date: new Date(),
			pv: pageViewCounter.get()
		};
	}

	function registerLaunchedVideo() {
		store.save(prepareData());
	}

	function videoCanBeLaunched() {
		return true; // TODO: implement
	}

	return {
		registerLaunchedVideo: registerLaunchedVideo,
		videoCanBeLaunched: videoCanBeLaunched
	};
});
