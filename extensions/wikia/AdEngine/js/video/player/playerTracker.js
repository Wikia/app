/*global define, Promise*/
define('ext.wikia.adEngine.video.player.playerTracker', [
	'wikia.log',
	'wikia.window'
], function (log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.playerTracker';

	/**
	 * @param {object} params
	 * @param {string} params.adProduct
	 * @param {string} params.slotName
	 * @param {string} playerName
	 * @param {string} eventName
	 * @param {int} [errorCode]
	 */
	function track(params, playerName, eventName, errorCode) {
		if (!params.adProduct) {
			log(['track', 'Missing ad product name'], log.levels.debug, logGroup);
			return;
		}


	}

	return {
		track: track
	};
});
