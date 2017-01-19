/*global define, Promise*/
define('ext.wikia.adEngine.video.player.porvata.porvataTracker', [
	'ext.wikia.adEngine.video.player.playerTracker'
], function (playerTracker) {
	'use strict';
	var playerName = 'porvata',
		trackingEventsMap = {
			'adCanPlay': 'ad_can_play',
			'allAdsCompleted': 'completed',
			'click': 'clicked',
			'firstquartile': 'first_quartile',
			'impression': 'impression',
			'loaded': 'loaded',
			'midpoint': 'midpoint',
			'pause': 'paused',
			'resume': 'resumed',
			'start': 'started',
			'thirdquartile': 'third_quartile',
			'viewable_impression': 'viewable',
			'adError': 'error'
		};

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

		Object.keys(trackingEventsMap).forEach(function (listener) {
			player.addEventListener(listener, function(event) {
				var errorCode = event.getError && event.getError().getErrorCode();
				playerTracker.track(params, playerName, trackingEventsMap[listener], errorCode);
			});
		});
	}

	return {
		register: register,
		track: track
	};
});
