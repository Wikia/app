/*global define*/
define('ext.wikia.adEngine.video.player.ooyala.ooyalaTracker', [
	'ext.wikia.adEngine.video.player.playerTracker',
	'wikia.window'
], function (playerTracker, win) {
	'use strict';
	var playerName = 'ooyala',
		trackingEventsMap = {
			'adsClickthroughOpened': 'clicked',
			'adsError': 'error',
			'adsPlayed': 'completed',
			'willPlayAds': 'loaded',
			'playerCreated': 'ready',
			'willPauseAds': 'paused',
			'willResumeAds': 'resumed',
			'willPlaySingleAd': 'started',

			'willPlay': 'content_started',
			'played': 'content_completed'
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
	 * @param {object} player created by porvataPlayerFactory
	 * @param {object} params
	 * @param {string} params.adProduct
	 * @param {string} [params.slotName]
	 */
	function register(player, params) {
		if (!win.OO || !player || !playerTracker.isEnabled()) {
			return;
		}

		Object.keys(trackingEventsMap).forEach(function (playerEvent) {
			player.mb.subscribe(playerEvent, 'ooyala-kikimora-tracking', function () {
				track(params, trackingEventsMap[playerEvent]);
			});
		});
	}

	return {
		register: register,
		track: track
	};
});
