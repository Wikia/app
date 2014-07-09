/*global require*/
require([
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.slot.bottomLeaderboard'
], function (log, window, eventDispatcher, bottomLeaderboard) {
	'use strict';

	if (!window.wgShowAds) {
		return false;
	}

	eventDispatcher.bind('ext.wikia.adEngine fillInSlot', function(slot, provider) {

		if (slot[0].indexOf('LEADERBOARD') !== -1 && (slot[2] === 'Liftium' || provider.name === 'Later')) {

			log(['Found call to liftium for leaderboard, launching', 'BOTTOM_LEADERBOARD'], 'debug', 'ext.wikia.adEngine.slot.bottomLeaderboard');

			bottomLeaderboard.init();
		}
	}, true);

});
