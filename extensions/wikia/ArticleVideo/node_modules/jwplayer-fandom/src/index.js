window.wikiaJWPlayer = function (elementId, options, callback) {
	function loadJWPlayerScript(elementId, playerURL, callback) {
		if (typeof jwplayer !== 'undefined') {
			callback();
			return;
		}
		var script = document.createElement('script'),
			playerElement = document.getElementById(elementId);
		script.onload = function () {
			wikiaJWPlayerSettingsPlugin.register();
			callback();
		};
		script.async = true;
		script.src = playerURL || 'https://content.jwplatform.com/libraries/VXc5h4Tf.js';
		// insert script node just after player element
		playerElement.parentNode.insertBefore(script, playerElement.nextSibling);
	}

	function setupPlayer(elementId, options) {
		var playerInstance = jwplayer(elementId),
			videoId = options.videoDetails.playlist[0].mediaid,
			willAutoplay = options.autoplay.enabled,
			playerSetup = {
				advertising: {
					autoplayadsmuted: willAutoplay,
					client: 'googima'
				},
				autostart: willAutoplay && !document.hidden,
				description: options.videoDetails.description,
				image: '//content.jwplatform.com/thumbs/' + videoId + '-640.jpg',
				mute: willAutoplay,
				playlist: options.videoDetails.playlist,
				title: options.videoDetails.title,
				plugins: {
					wikiaSettings: {
						showToggle: options.autoplay.showToggle,
						autoplay: options.autoplay.enabled
					}
				}
			};

		if (options.related) {
			playerSetup.related = {
				autoplaytimer: options.related.time || 3,
				file: 'https://cdn.jwplayer.com/v2/playlists/' + options.related.playlistId + '?related_media_id=' + videoId,
				oncomplete: options.related.autoplay ? 'autoplay' : 'show'
			};
		}

		logger.info('jwplayer setupPlayer');
		playerInstance.setup(playerSetup);
		logger.info('jwplayer after setup');
		logger.subscribeToPlayerErrors(playerInstance);

		return playerInstance;
	}

	var logger = wikiaJWPlayerLogger(options);
	loadJWPlayerScript(elementId, options.playerURL, function () {
		var playerInstance = setupPlayer(elementId, options);
		wikiaJWPlayerReplaceIcons(playerInstance);
		wikiaJWPlayerEvents(playerInstance, options.autoplay.enabled, logger);
		if (options.tracking) {
			wikiaJWPlayerTracking(playerInstance, options.autoplay.enabled, 'feautred-video', options.tracking);
		}
		wikiaJWPlayerHandleTabNotActive(playerInstance, options.autoplay.enabled);
		if (callback) {
			callback(playerInstance);
		}
	});
};
