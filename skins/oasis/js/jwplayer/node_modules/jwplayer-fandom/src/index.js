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

			if (options.sharing) {
				wikiaJWPlayerSharingPlugin.register();
			}

			if (options.showSmallPlayerControls) {
				wikiaJWPlayerSmallPlayerControls.register();
			}

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
	 * @param logger
	 * @param lang
	 * @param i18n
	 * @return {*}
	 */
	function setupPlayer(elementId, options, logger, lang, i18n) {
		var playerInstance = jwplayer(elementId),
			videoId = options.videoDetails.playlist[0].mediaid,
			willAutoplay = options.autoplay,
			// IMA supports two-letter ISO 639-1 code
			langForAds = lang.substr(0, 2),
			playerSetup = {
				advertising: {
					admessage: i18n.admessage,
					autoplayadsmuted: willAutoplay,
					client: 'googima',
					cuetext: i18n.cuetext,
					loadVideoTimeout: 16000,
					maxRedirects: 8,
					requestTimeout: 11500,
					setLocale: langForAds,
					skipmessage: i18n.skipmessage,
					skiptext: i18n.skiptext,
					truncateMacros: false,
					vastLoadTimeout: 11000,
					vpaidcontrols: true
				},
				autostart: willAutoplay && !document.hidden,
				description: options.videoDetails.description,
				image: '//content.jwplatform.com/thumbs/' + videoId + '-640.jpg',
				mute: options.mute,
				playlist: options.videoDetails.playlist,
				title: options.videoDetails.title,
				localization: i18n,
				repeat: options.repeat
			};

		playerSetup.plugins = {};

		if (options.settings) {
			playerSetup.plugins['wikiaSettings'] = {
				showAutoplayToggle: options.settings.showAutoplayToggle,
				showQuality: options.settings.showQuality,
				showCaptions: options.settings.showCaptions,
				autoplay: options.autoplay,
				selectedCaptionsLanguage: options.selectedCaptionsLanguage,
				i18n: i18n
			};
		}

		if (options.sharing) {
			playerSetup.plugins['wikiaSharing'] = {
				i18n: i18n
			};
		}

		if (options.related) {
			playerSetup.related = {
				autoplaytimer: options.related.time || 3,
				file: '//cdn.jwplayer.com/v2/playlists/' + options.related.playlistId + '?related_media_id=' + videoId,
				oncomplete: options.related.autoplay ? 'autoplay' : 'show',
				autoplaymessage: i18n.nextUpInSeconds
			};
		}

		if (options.watermark !== false) {
			playerSetup.plugins['wikiaWatermark'] = {};
		}

		if (options.showSmallPlayerControls) {
			playerSetup.plugins['smallPlayerControls'] = {};
		}

		logger.info('setupPlayer');
		playerInstance.setup(playerSetup);
		logger.info('after setup');
		logger.subscribeToPlayerErrors(playerInstance);

		return playerInstance;
	}

	loadJWPlayerScript(elementId, options.playerURL, function () {
		var logger = wikiaJWPlayerLogger(options),
			lang = options.lang || 'en',
			i18n = wikiaJWPlayeri18n[lang] || wikiaJWPlayeri18n['en'],
			playerInstance = setupPlayer(elementId, options, logger, lang, i18n);

		wikiaJWPlayerIdleScreen(playerInstance, i18n);
		wikiaJWPlayerReplaceIcons(playerInstance);
		wikiaJWPlayerEvents(playerInstance, options.autoplay, logger);

		if (options.related) {
			wikiaJWPlayerRelatedVideoSound(playerInstance);
		}

		if (options.tracking) {
			options.tracking.pixel = options.videoDetails.playlist[0].pixel;
			wikiaJWPlayerTracking(playerInstance, options.autoplay, options.tracking);
		}

		wikiaJWPlayerHandleTabNotActive(playerInstance, options.autoplay);

		wikiaJWPlayerAllowControllOnTouchDevices(playerInstance);

		wikiaJWPlayerUserIntendedPlayControl(
			options.shouldForceUserIntendedPlay,
			playerInstance,
			options.tracking,
			options.autoplay
		);

		if(options.watermark !== false) {
			WikiaJWPlayerWatermarkPlugin.register();
		}

		if (callback) {
			callback(playerInstance);
		}
	});
};
