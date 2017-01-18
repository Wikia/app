/*global define*/
define('ext.wikia.adEngine.video.player.porvata', [
	'ext.wikia.adEngine.video.player.porvata.porvataTracker',
	'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory',
	'ext.wikia.adEngine.video.player.porvata.googleIma',
	'wikia.log',
	'wikia.viewportObserver'
], function (poravataTracker, porvataPlayerFactory, googleIma, log, viewportObserver) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata',
		trackingParams;

	function inject(params) {
		var autoPlayed = false,
			autoPaused = false,
			viewportListener;

		log(['injecting porvata player', params], log.levels.debug, logGroup);
		poravataTracker.track(trackingParams, 'init');

		params.vastTargeting = params.vastTargeting || {
			src: params.src,
			pos: params.slotName,
			passback: 'porvata'
		};

		return googleIma.load()
			.then(function () {
				log('google ima loaded', log.levels.debug, logGroup);

				return googleIma.getPlayer(params);
			}).then(function (ima) {
				log(['ima player set up', ima], log.levels.debug, logGroup);

				return porvataPlayerFactory.create(params, ima);
			}).then(function (video) {
				log(['porvata video player created', video], log.levels.debug, logGroup);

				function inViewportCallback(isVisible) {
					// Play video automatically only for the first time
					if (isVisible && !autoPlayed && params.autoPlay) {
						video.play();
						autoPlayed = true;
					// Don't resume when video was paused manually
					} else if (isVisible && autoPaused) {
						video.resume();
					// Pause video once it's out of viewport and set autoPaused to distinguish manual and auto pause
					} else if (!isVisible && video.isPlaying()) {
						video.pause();
						autoPaused = true;
					}
				}

				video.addEventListener('adCanPlay', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdStarted');
					poravataTracker.track(trackingParams, 'adRequest');
				});
				video.addEventListener('allAdsCompleted', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdCompleted');
					video.ima.setAutoPlay(false);

					if (viewportListener) {
						viewportObserver.removeListener(viewportListener);
					}

					poravataTracker.track(trackingParams, 'adComplete');
				});
				video.addEventListener('start', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
					poravataTracker.track(trackingParams, 'adStarted');
				});
				video.addEventListener('resume', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
					autoPaused = false;
					poravataTracker.track(trackingParams, 'adStarted');
				});
				video.addEventListener('pause', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPause');
				});

				if (params.onReady) {
					params.onReady(video);
				}

				viewportListener = viewportObserver.addListener(params.container, inViewportCallback);

				poravataTracker.track(trackingParams, 'ready');
				return video;
			});
	}

	return {
		inject: inject
	};
});
