/*global define*/
define('ext.wikia.adEngine.video.player.porvata', [
	'ext.wikia.adEngine.video.player.porvata.googleIma',
	'ext.wikia.adEngine.video.player.porvata.porvataPlayerFactory',
	'ext.wikia.adEngine.video.player.porvata.porvataTracker',
	'wikia.log',
	'wikia.viewportObserver'
], function (googleIma, porvataPlayerFactory, tracker, log, viewportObserver) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.porvata';

	function inject(params) {
		var autoPlayed = false,
			autoPaused = false,
			viewportListener;

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

				return googleIma.getPlayer(params);
			}).then(function (ima) {
				log(['ima player set up', ima], log.levels.debug, logGroup);

				return porvataPlayerFactory.create(params, ima);
			}).then(function (video) {
				log(['porvata video player created', video], log.levels.debug, logGroup);
				tracker.register(video, params);

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
				});
				video.addEventListener('allAdsCompleted', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdCompleted');
					video.ima.setAutoPlay(false);

					if (viewportListener) {
						viewportObserver.removeListener(viewportListener);
					}
				});
				video.addEventListener('start', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
				});
				video.addEventListener('resume', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPlay');
					autoPaused = false;
				});
				video.addEventListener('pause', function () {
					video.ima.getAdsManager().dispatchEvent('wikiaAdPause');
				});

				if (params.onReady) {
					params.onReady(video);
				}

				viewportListener = viewportObserver.addListener(params.container, inViewportCallback);

				return video;
			});
	}

	return {
		inject: inject
	};
});
