/*global define*/
define('ext.wikia.adEngine.video.player.porvata.porvataTracker', [
	'ext.wikia.adEngine.video.player.playerTracker'
], function (playerTracker) {
	'use strict';
	var playerName = 'porvata',
		trackingEventsMap = {
			'adCanPlay': 'ad_can_play',
			'complete': 'completed',
			'click': 'clicked',
			'firstquartile': 'first_quartile',
			'impression': 'impression',
			'loaded': 'loaded',
			'midpoint': 'midpoint',
			'pause': 'paused',
			'resume': 'resumed',
			'start': 'started',
			'thirdquartile': 'third_quartile',
			'viewable_impression': 'viewable_impression',
			'adError': 'error',
			'wikiaAdPlayTriggered': 'play_triggered',
			'wikiaAdStop': 'closed',
			'wikiaAdMute': 'mute',
			'wikiaAdUnmute': 'unmute',
			'wikiaInViewportWithDirect': 'in_viewport_with_direct',
			'wikiaInViewportWithFallbackBid': 'in_viewport_with_fallback_bid',
			'wikiaInViewportWithoutOffer': 'in_viewport_without_offer'
		};

	function getAd(player) {
		if (player) {
			return player.ima.getAdsManager() && player.ima.getAdsManager().getCurrentAd();
		}
	}

	function getContentType(player) {
		var ad = getAd(player);
		if (ad) {

			return ad.getContentType();
		}
	}

	function getAdId(player) {
		var ad = getAd(player);

		if (ad) {
			return ad.getAdId();
		}
	}

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
	 * @param {object} [player]
	 */
	function track(params, eventName, errorCode, player) {
		var contentType = getContentType(player);

		params.vastId = getAdId(player);

		playerTracker.track(params, playerName, eventName, errorCode, contentType);
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

		params.withAudio = !params.autoPlay;

		track(params, 'ready');

		Object.keys(trackingEventsMap).forEach(function (playerEvent) {
			player.addEventListener(playerEvent, function(event) {
				var errorCode = event.getError && event.getError().getErrorCode();
				track(params, trackingEventsMap[playerEvent], errorCode, player);
			});
		});
	}

	return {
		register: register,
		track: track
	};
});
