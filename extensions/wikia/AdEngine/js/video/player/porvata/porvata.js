/*global define*/
define('ext.wikia.adEngine.video.player.porvata', [
	'ext.wikia.adEngine.video.player.porvata.googleIma',
	'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory',
	'ext.wikia.adEngine.video.player.porvata.porvataTracker',
	'wikia.log',
	'wikia.viewportObserver',
	'ext.wikia.adEngine.video.player.ui.videoInterface',
	'ext.wikia.adEngine.video.player.uiTemplate',
	require.optional('ext.wikia.adEngine.video.player.porvata.floater'),
], function (googleIma, porvataPlayerFactory, tracker, log, viewportObserver, videoInterface, uiTemplate, floater) {
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
				log(['porvata video player created', video], log.levels.debug, logGroup);
				tracker.register(video, params);

				function shouldPause(isVisible) {
					// force not pausing when outside of viewport
					return !params.blockOutOfViewportPausing
						// Pause video once it's out of viewport and set autoPaused to distinguish manual and auto pause
						&& !isVisible && video.isPlaying()
						// Do not pause when video floating is active
						&& !isFloatingEnabled(params);
				}

				function inViewportCallback(isVisible) {
					// Play video automatically only for the first time
					if (isVisible && !autoPlayed && videoSettings.isAutoPlay()) {
						video.play();
						autoPlayed = true;
						// Don't resume when video was paused manually
					} else if (isVisible && autoPaused && !isFloatingEnabled(params)) {
						video.resume();
					} else if (shouldPause(isVisible)) {
						video.pause();
						autoPaused = true;
					}
				}

				video.addEventListener('adCanPlay', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdStarted');
				});

				video.addEventListener('allAdsCompleted', function () {
					isFirstPlay = false;
					video.ima.getAdsManager().dispatchEvent('wikiaAdCompleted');
					video.ima.setAutoPlay(false);

					if (viewportListener) {
						viewportObserver.removeListener(viewportListener);
						viewportListener = null;
					}
				});
				video.addEventListener('start', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
					if (!viewportListener) {
						viewportListener = viewportObserver.addListener(params.container, inViewportCallback);
					}
				});
				video.addEventListener('resume', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
					autoPaused = false;
				});
				video.addEventListener('pause', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPause');
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

				if (params.onReady) {
					params.onReady(video);
				}

				viewportListener = viewportObserver.addListener(params.container, inViewportCallback);

				tryEnablingFloating(video, inViewportCallback);

				return video;
			}).then(function (video) {

				if (params.hasUiControls) {
					var interactiveArea = document.createElement('div'),
						controlBar = document.createElement('div'),
						controlBarItems = document.createElement('div');

					interactiveArea.classList.add('interactive-area');
					controlBar.classList.add('control-bar');
					controlBarItems.classList.add('control-bar-items');

					controlBar.appendChild(controlBarItems);
					interactiveArea.appendChild(controlBar);
					video.container.appendChild(interactiveArea);

					videoInterface.setup(video, uiTemplate.otherLayout, {
						controlBar: controlBar,
						controlBarItems: controlBarItems
					});
				}

				return video;
			});
	}

	return {
		inject: inject
	};
});
