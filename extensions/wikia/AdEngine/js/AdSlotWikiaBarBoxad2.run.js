/*global require*/
require([
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.eventDispatcher',
	'ext.wikia.adEngine.slot.wikiaBarBoxad2'
], function (log, window, eventDispatcher, wikiaBarBoxad2) {
	'use strict';

	if (!window.wgShowAds) {
		return false;
	}

	eventDispatcher.bind('ext.wikia.adEngine fillInSlot', function(slot, provider) {

		if (slot[0].indexOf('LEADERBOARD') !== -1 && (slot[2] === 'Liftium' || provider.name === 'Later')) {

			log(['Found call to liftium for leaderboard, launching', 'WIKIA_BAR_BOXAD_2'], 'debug', 'ext.wikia.adEngine.slot.wikiaBarBoxad2');

			wikiaBarBoxad2.init();
		}
	}, true);

});
