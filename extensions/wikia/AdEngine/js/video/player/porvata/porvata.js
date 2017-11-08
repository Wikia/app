/*global define*/
define('ext.wikia.adEngine.video.player.porvata', [
	'ext.wikia.adEngine.video.player.porvata.googleIma',
	'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory',
	'ext.wikia.adEngine.video.player.porvata.porvataTracker',
	'wikia.document',
	'wikia.log',
	'wikia.viewportObserver',
	require.optional('ext.wikia.adEngine.video.player.porvata.floater')
], function (googleIma, porvataPlayerFactory, tracker, doc, log, viewportObserver, floater) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata';

	function inject(videoSettings) {
		var params = videoSettings.getParams(),
			isFirstPlay = true,
			autoPlayed = false,
			autoPaused = false,
			viewportListener = null;

		function isFloatingEnabled(params) {
			return params.floatingContext && params.floatingContext.isActive();
		}

		function tryEnablingFloating(video, inViewportCallback) {
			if (floater && floater.canFloat(params)) {
				params.floatingContext = floater.makeFloat(video, params, {
					onStart: function () {
						inViewportCallback(true);
					},
					onEnd: function () {
						inViewportCallback(false);
					}
				});
			}
		}

		function muteFirstPlay(video) {
			video.addEventListener('loaded', function () {
				if (isFirstPlay) {
					video.mute();
				}
			});
		}

		log(['injecting porvata player', params], log.levels.debug, logGroup);
		tracker.track(params, 'init');

		params.vastTargeting = params.vastTargeting || {
			src: params.src,
			pos: params.slotName,
			passback: 'porvata'
		};

		return googleIma.load()
			.then(function () {
				log('google ima loaded', log.levels.debug, logGroup);

				return googleIma.getPlayer(videoSettings);
			}).then(function (ima) {
				log(['ima player set up', ima], log.levels.debug, logGroup);

				return porvataPlayerFactory.create(videoSettings, ima);
			}).then(function (video) {
				var viewportHook = params.container;

				video.wasInViewport = false;
				log(['porvata video player created', video], log.levels.debug, logGroup);
				tracker.register(video, params);

				if (params.viewportHookSelector) {
					viewportHook = doc.querySelector(params.viewportHookSelector) || viewportHook;
				}

				function shouldResume(isVisible) {
					// Don't resume when video was paused manually
					return isVisible && autoPaused &&
						// Do not resume when video floating is active
						!isFloatingEnabled(params);
				}

				function shouldPause(isVisible) {
					// force not pausing when outside of viewport
					return !params.blockOutOfViewportPausing &&
						// Pause video once it's out of viewport and set autoPaused to distinguish manual and auto pause
						!isVisible && video.isPlaying() &&
						// Do not pause when video floating is active
						!isFloatingEnabled(params);
				}

				function inViewportCallback(isVisible) {
					video.wasInViewport = true;
					// Play video automatically only for the first time
					if (isVisible && !autoPlayed && videoSettings.isAutoPlay()) {
						video.ima.dispatchEvent('wikiaFirstTimeInViewport');
						video.play();
						autoPlayed = true;
					} else if (shouldResume(isVisible)) {
						video.resume();
					} else if (shouldPause(isVisible)) {
						video.pause();
						autoPaused = true;
					}
				}

				video.addEventListener('adCanPlay', function () {
					video.ima.dispatchEvent('wikiaAdStarted');
				});

				video.addEventListener('allAdsCompleted', function () {
					isFirstPlay = false;
					video.ima.setAutoPlay(false);
					video.ima.dispatchEvent('wikiaAdCompleted');

					if (viewportListener) {
						viewportObserver.removeListener(viewportListener);
						viewportListener = null;
					}
				});
				video.addEventListener('start', function () {
					video.ima.dispatchEvent('wikiaAdPlay');
					if (!viewportListener) {
						viewportListener = viewportObserver.addListener(viewportHook, inViewportCallback);
					}
				});
				video.addEventListener('loaded', function () {
					tryEnablingFloating(video, inViewportCallback);
				});
				video.addEventListener('resume', function () {
					video.ima.dispatchEvent('wikiaAdPlay');
					autoPaused = false;
				});
				video.addEventListener('pause', function () {
					video.ima.dispatchEvent('wikiaAdPause');
				});
				video.addOnDestroyCallback(function () {
					if (viewportListener) {
						viewportObserver.removeListener(viewportListener);
						viewportListener = null;
					}
				});

				if (videoSettings.isAutoPlay()) {
					muteFirstPlay(video);
				}

				video.addEventListener('wikiaAdsManagerLoaded', function () {
					viewportListener = viewportObserver.addListener(viewportHook, inViewportCallback);
				});
				video.addEventListener('wikiaEmptyAd', function () {
					viewportListener = viewportObserver.addListener(viewportHook, inViewportCallback);
				});

				return video;
			});
	}

	return {
		inject: inject
	};
});
