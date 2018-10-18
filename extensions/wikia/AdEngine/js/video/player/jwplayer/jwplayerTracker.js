/*global define, require*/
define('ext.wikia.adEngine.video.player.jwplayer.jwplayerTracker', [
	'ext.wikia.adEngine.video.player.playerTracker',
	'ext.wikia.adEngine.video.vastParser',
	'wikia.log',
	require.optional('wikia.articleVideo.featuredVideo.cookies')
], function (
	playerTracker,
	vastParser,
	log,
	featuredVideoCookieService
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
		},
		logGroup = 'ext.wikia.adEngine.video.player.jwplayer.jwplayerTracker';

	function track(params, eventName, errorCode) {
		if (featuredVideoCookieService) {
			params.userBlockAutoplay = -1;
			var cookieValue = featuredVideoCookieService.getAutoplay();
			if (['0', '1'].indexOf(cookieValue) > -1) {
				params.userBlockAutoplay = cookieValue === '0' ? 1 : 0;
			}
		}

		playerTracker.track(params, playerName, eventName, errorCode);
	}

	function register(player, params) {
		if (!playerTracker.isEnabled()) {
			return;
		}

		var isCtpAudioUpdateEnabled = true;

		params.withCtp = !player.getConfig().autostart;
		params.withAudio = !player.getConfig().mute;

		/**
		 * Updates properties withCtp and withAudio of params object.
		 *
		 * If vastParams is provided, the values are extracted from it.
		 * If vastParams is provided, it also disables further updates.
		 *
		 * Otherwise it uses player config values (less reliable).
		 *
		 * @param {Object | null} vastParams
		 */
		function updateCtpAudio(vastParams) {
			log(['updateCtpAudio', params, vastParams], log.levels.debug, logGroup);
			if(vastParams && vastParams.customParams) {
				params.withAudio = vastParams.customParams.audio === 'yes';
				params.withCtp = vastParams.customParams.ctp === 'yes';
				isCtpAudioUpdateEnabled = false;
				log(['updateCtpAudio disabling ctpAudioUpdate'], log.levels.debug, logGroup);
			} else {
				params.withAudio = !player.getMute();
				params.withCtp = !player.getConfig().autostart;
			}
		}

		Object.keys(trackingEventsMap).forEach(function (playerEvent) {
			player.on(playerEvent, function(event) {
				var errorCode;

				// Update ctp and audio on the following events if isCtpAudioUpdateEnabled
				if ([
					'ready',
					'adRequest',
					'adError',
					'videoStart'
				].indexOf(playerEvent) > -1 && isCtpAudioUpdateEnabled) {
					var vastParams = event.tag ? vastParser.parse(event.tag) : null;
					updateCtpAudio(vastParams);
				}

				if (playerEvent === 'adError') {
					errorCode = event && event.code;
				}

				track(params, trackingEventsMap[playerEvent], errorCode);

				// Disable updating ctp and audio on video completed event
				// It is a failsafe for the case where updating
				// has not been disabled by calling updateCtpAudio with VAST params
				if (playerEvent === 'complete') {
					log(
						['video completed, disabling ctpAudioUpdate and setting withCtp to false'],
						log.levels.debug,
						logGroup
					);
					isCtpAudioUpdateEnabled = false;
					params.withCtp = false;
				}
			});
		});
	}

	return {
		register: register,
		track: track
	};
});
