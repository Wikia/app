/*global define, Promise*/
define('ext.wikia.adEngine.video.player.porvata.porvataTracker', [
	'ext.wikia.adEngine.video.player.playerTracker'
], function (playerTracker) {
	'use strict';
	var playerName = 'porvata';

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
		playerTracker.track(params, playerName, eventName, errorCode);
	}

	/**
	 * @param {object} player created by porvataPlayerFactory
	 * @param {object} params
	 * @param {string} params.adProduct
	 * @param {string} [params.creativeId]
	 * @param {string} [params.lineItemId]
	 * @param {string} [params.slotName]
	 * @param {string} [params.src]
	 * @param {string} [params.trackingDisabled]
	 */
	function register(player, params) {
		var originalPlay = player.play;

		playerTracker.track(params, playerName, 'ready');

		player.play = function() {
			playerTracker.track(params, playerName, 'play_triggered');
			originalPlay.apply(player, arguments);
		};
	}

	return {
		register: register,
		track: track
	};
});
