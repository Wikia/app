/*global define*/
define('ext.wikia.adEngine.video.player.ooyala.ooyalaTracker', [
	'ext.wikia.adEngine.video.player.playerTracker',
	'wikia.window'
], function (playerTracker, win) {
	'use strict';
	var playerName = 'ooyala',
		trackingEventsMap = {
			// This event is not exposed in OO.EVENTS and there is no other equivalent
			adsClickthroughOpened: 'clicked',

			ADS_ERROR: 'error',
			ADS_PLAYED: 'completed',
			WILL_PLAY_ADS: 'loaded',
			PLAYER_CREATED: 'ready',
			WILL_PAUSE_ADS: 'paused',
			WILL_RESUME_ADS: 'resumed',
			WILL_PLAY_SINGLE_AD: 'started',

			WILL_PLAY: 'content_started',
			PLAYED: 'content_completed'
		};

	/**
	 * @param {object} params
	 * @param {string} params.adProduct
	 * @param {string} [params.slotName]
	 * @param {string} eventName
	 */
	function track(params, eventName) {
		playerTracker.track(params, playerName, eventName);
	}

	/**
	 * @param {object} player
	 * @param {object} params
	 * @param {string} params.adProduct
	 * @param {string} [params.slotName]
	 */
	function register(player, params) {
		if (!win.OO || !player || !playerTracker.isEnabled()) {
			return;
		}

		Object.keys(trackingEventsMap).forEach(function (playerEvent) {
			player.mb.subscribe(win.OO.EVENTS[playerEvent] || playerEvent, 'ooyala-kikimora-tracking', function () {
				track(params, trackingEventsMap[playerEvent]);
			});
		});
	}

	return {
		register: register,
		track: track
	};
});
