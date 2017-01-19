/*global define, Promise*/
define('ext.wikia.adEngine.video.player.porvata.porvataTracker', [
	'ext.wikia.adEngine.video.player.playerTracker'
], function (playerTracker) {
	'use strict';

	/**
	 * @param {object} params
	 * @param {string} params.adProduct
	 * @param {string} [params.creativeId]
	 * @param {string} [params.lineItemId]
	 * @param {string} [params.slotName]
	 * @param {string} [params.src]
	 * @param {string} [params.trackingDisabled]
	 * @param {string} eventName
	 * @param {int} [errorCode]
	 */
	function track(params, eventName, errorCode) {
		playerTracker.track(params, 'porvata', eventName, errorCode);
	}

	return {
		track: track
	};
});
