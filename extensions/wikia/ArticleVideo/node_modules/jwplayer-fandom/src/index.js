var loadCallbacks = [];

window.wikiaJWPlayer = function (elementId, options, callback) {

	/**
	 * adds script tag
	 * @param elementId
	 * @param playerURL
	 */
	function createScriptTag(elementId, playerURL) {
		var script = document.createElement('script'),
			playerElement = document.getElementById(elementId);

		script.onload = function () {
			wikiaJWPlayerSettingsPlugin.register();
			loadCallbacks.forEach(function (callback) {
				callback();
			});
		};
		script.async = true;
		script.src = playerURL || 'https://content.jwplatform.com/libraries/VXc5h4Tf.js';
		// insert script node just after player element
		playerElement.parentNode.insertBefore(script, playerElement.nextSibling);
	}

	/**
	 * loads jwplayer library
	 * @param elementId
	 * @param playerURL
	 * @param callback
	 */
	function loadJWPlayerScript(elementId, playerURL, callback) {
		if (typeof jwplayer !== 'undefined') {
			callback();
		} else {
			loadCallbacks.push(callback);

			// we don't want to load multiple jwplayer libraries
			if (loadCallbacks.length === 1) {
				createScriptTag(elementId, playerURL);
			}
		}
	}

	/**
	 * setups player
	 * @param elementId
	 * @param options
	 * @return {*}
	 */
	function setupPlayer(elementId, options, logger) {
		var playerInstance = jwplayer(elementId),
			videoId = options.videoDetails.playlist[0].mediaid,
			willAutoplay = options.autoplay,
			playerSetup = {
				advertising: {
					autoplayadsmuted: willAutoplay,
					client: 'googima',
					vpaidcontrols: true
				},
				autostart: willAutoplay && !document.hidden,
				description: options.videoDetails.description,
				image: '//content.jwplatform.com/thumbs/' + videoId + '-640.jpg',
				mute: willAutoplay,
				playlist: options.videoDetails.playlist,
				title: options.videoDetails.title
			};

		if (options.settings) {
			playerSetup.plugins = {
				wikiaSettings: {
					showAutoplayToggle: options.settings.showAutoplayToggle,
					showQuality: options.settings.showQuality,
					showCaptionsToggle: options.settings.showCaptionsToggle,
					autoplay: options.autoplay
				}
			};
		}

		if (options.related) {
			playerSetup.related = {
				autoplaytimer: options.related.time || 3,
				file: '//cdn.jwplayer.com/v2/playlists/' + options.related.playlistId + '?related_media_id=' + videoId,
				oncomplete: options.related.autoplay ? 'autoplay' : 'show'
			};
		}

		logger.info('setupPlayer');
		playerInstance.setup(playerSetup);
		logger.info('after setup');
		logger.subscribeToPlayerErrors(playerInstance);

		return playerInstance;
	}

	loadJWPlayerScript(elementId, options.playerURL, function () {
		var logger = wikiaJWPlayerLogger(options),
			playerInstance = setupPlayer(elementId, options, logger);

		wikiaJWPlayerReplaceIcons(playerInstance);
		wikiaJWPlayerEvents(playerInstance, options.autoplay, logger);
		if (options.related) {
			wikiaJWPlayerRelatedVideoSound(playerInstance);
		}

		if (options.tracking) {
			wikiaJWPlayerTracking(playerInstance, options.autoplay, options.tracking);
		}

		wikiaJWPlayerHandleTabNotActive(playerInstance, options.autoplay);

		if (callback) {
			callback(playerInstance);
		}
	});
};
