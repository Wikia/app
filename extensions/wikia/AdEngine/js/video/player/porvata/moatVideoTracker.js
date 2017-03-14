/*global define*/
define('ext.wikia.adEngine.video.player.porvata.moatVideoTracker', [
	'wikia.log',
	'wikia.window'
], function (log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.porvata.moatVideoTracker',
		partnerCode = 'wikiaimajsint377461931603';

	function init(adsManager, container, viewMode, slicer1, slicer2) {
		var ids = {
				partnerCode: partnerCode,
				viewMode: viewMode,
				slicer1: slicer1,
				slicer2: slicer2
			};

		try {
			win.initMoatTracking(adsManager, ids, container);
			log('MOAT video tracking initialized', log.levels.debug, logGroup);
		} catch (error) {
			log(['MOAT video tracking initalization error', error], log.levels.debug, logGroup);

		}
	}

	return {
		init: init
	};
});
