/*global require*/
require([
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.slot.bottomLeaderboard'
], function (log, adContext, eventDispatcher, bottomLeaderboard) {
	'use strict';

	if (!adContext.getContext().opts.showAds) {
		return false;
	}

	eventDispatcher.bind('ext.wikia.adEngine fillInSlot', function(slot, provider) {

		if (slot[0].indexOf('LEADERBOARD') !== -1 && (slot[2] === 'Liftium' || provider.name === 'Later')) {

			log(['Found call to liftium for leaderboard, launching', 'BOTTOM_LEADERBOARD'], 'debug', 'ext.wikia.adEngine.slot.bottomLeaderboard');

			bottomLeaderboard.init();
		}
	}, true);

});
