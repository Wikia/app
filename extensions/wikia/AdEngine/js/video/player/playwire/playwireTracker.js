/*global define*/
define('ext.wikia.adEngine.video.player.playwire.playwireTracker', [
	'ext.wikia.adEngine.video.player.playerTracker'
], function (playerTracker) {
	'use strict';
	var playerName = 'playwire',
		trackingEventsMap = {
			'boltAdRequestStart': 'loaded',
			'boltAdStarted': 'started',
			'boltFirstQuartile': 'first_quartile',
			'boltMidPoint': 'midpoint',
			'boltThirdQuartile': 'third_quartile',
			'boltAdComplete': 'completed',
			'boltAdClicked': 'clicked',
			'boltAdError': 'error',
			'boltContentStarted': 'content_started',
			'boltContentComplete': 'content_completed',
			'boltContentError': 'content_error',
			'wikiaAdPlayTriggered': 'play_triggered',
			'wikiaAdStop': 'closed'
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
		if (!playerTracker.isEnabled()) {
			return;
		}

		playerTracker.track(params, playerName, 'ready');

		Object.keys(trackingEventsMap).forEach(function (playerEvent) {
			player.api.addEventListener(player.id, playerEvent, function() {
				playerTracker.track(params, playerName, trackingEventsMap[playerEvent]);
			});
		});
	}

	return {
		register: register,
		track: track
	};
});
