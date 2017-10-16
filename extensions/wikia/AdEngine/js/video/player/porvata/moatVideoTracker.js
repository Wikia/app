/*global define*/
define('ext.wikia.adEngine.video.player.porvata.moatVideoTracker', [
	'wikia.log',
	'wikia.window'
], function (log, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.porvata.moatVideoTracker',
		partnerCode = 'wikiaimajsint377461931603';

	function init(adsManager, container, viewMode, src, pos) {
		var ids = {
				partnerCode: partnerCode,
				viewMode: viewMode,
				slicer1: src,
				slicer2: pos
			};

		try {
			win.initMoatTracking(adsManager, ids, container, src, pos);
			log(['MOAT video tracking initialized with params', adsManager, ids, container, src, pos], log.levels.debug, logGroup);
		} catch (error) {
			log(['MOAT video tracking initalization error', error], log.levels.debug, logGroup);
		}
	}

	return {
		init: init
	};
});
