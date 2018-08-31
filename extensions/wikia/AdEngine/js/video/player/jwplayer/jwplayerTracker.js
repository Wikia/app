/*global define*/
define('ext.wikia.adEngine.video.player.jwplayer.jwplayerTracker', [
	'ext.wikia.adEngine.video.player.playerTracker'
], function (
	playerTracker
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

		var skipCtpAudioUpdate = false;

		function updateCtpAudio() {
			if (skipCtpAudioUpdate) {
				skipCtpAudioUpdate = false;
			} else {
				params.withCtp = !player.getConfig().autostart;
				params.withAudio = !player.getConfig().mute;
			}
		}

		updateCtpAudio();

		Object.keys(trackingEventsMap).forEach(function (playerEvent) {
			player.on(playerEvent, function(event) {
				var errorCode;

				if (['adRequest', 'adError', 'ready', 'videoStart'].indexOf(playerEvent) !== -1) {
					updateCtpAudio();

					if (playerEvent === 'adRequest' || playerEvent === 'adError') {
						skipCtpAudioUpdate = true;
					}

					if (playerEvent === 'adError') {
						errorCode = event && event.code;
					}
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
