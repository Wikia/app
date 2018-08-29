/*global define*/
define('ext.wikia.adEngine.video.player.jwplayer.jwplayerTracker', [
	'ext.wikia.adEngine.video.player.playerTracker',
	'ext.wikia.adEngine.video.vastParser'
], function (
	playerTracker,
	vastParser
) {
	'use strict';
	var playerName = 'jwplayer',
		trackingEventsMap = {
			ready: 'ready',
			adBlock: 'blocked',
			adClick: 'clicked',
			adRequest: 'loaded',
			adError: 'error',
			adImpression: 'impression',
			adStarted: 'started',
			adViewableImpression: 'viewable_impression',
			adFirstQuartile: 'first_quartile',
			adMidPoint: 'midpoint',
			adThirdQuartile: 'third_quartile',
			adComplete: 'completed',
			adSkipped: 'skipped',
			videoStart: 'content_started',
			complete: 'content_completed'
		};

	function track(params, eventName, errorCode) {
		playerTracker.track(params, playerName, eventName, errorCode);
	}

	function register(player, params) {
		if (!playerTracker.isEnabled()) {
			return;
		}

		params.withAudio = !player.getConfig().mute;

		Object.keys(trackingEventsMap).forEach(function (playerEvent) {
			player.on(playerEvent, function(event) {
				var errorCode,
					vastParams = vastParser.parse(event.tag);

				if (params.withCtp === undefined && vastParams.customParams && vastParams.customParams.ctp !== undefined) {
					params.withCtp = vastParams.customParams.ctp === 'yes';
				}

				if (playerEvent === 'adError') {
					errorCode = event && event.code;
				}

				track(params, trackingEventsMap[playerEvent], errorCode);
			});
		});
	}

	return {
		register: register,
		track: track
	};
});
