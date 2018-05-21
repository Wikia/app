require([
	'wikia.window',
	'wikia.geo',
//	'wikia.instantGlobals',
	'wikia.cookies',
	'wikia.tracker',
	'wikia.trackingOptIn',
	'wikia.abTest',
	'ext.wikia.adEngine.adContext',
	'wikia.articleVideo.featuredVideo.data',
	'wikia.articleVideo.featuredVideo.ads',
	'wikia.articleVideo.featuredVideo.moatTracking',
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine.lookup.a9')
], function (
	win,
	geo,
//	instantGlobals,
	cookies,
	tracker,
	trackingOptIn,
	abTest,
	adContext,
	videoDetails,
	featuredVideoAds,
	featuredVideoMoatTracking,
	featuredVideoCookieService,
	a9
) {
	if (!videoDetails) {
		return;
	}

	var inNextVideoAutoplayCountries = true, //geo.isProperGeo(instantGlobals.wgArticleVideoNextVideoAutoplayCountries),
		//Fallback to the generic playlist when no recommended videos playlist is set for the wiki
		recommendedPlaylist = videoDetails.recommendedVideoPlaylist || 'Y2RWCKuS',
		videoTags = videoDetails.videoTags || '',
		inAutoplayCountries = true, //geo.isProperGeo(instantGlobals.wgArticleVideoAutoplayCountries),
		inFeaturedVideoClickToPlayABTest = abTest.inGroup('FV_CLICK_TO_PLAY', 'CLICK_TO_PLAY'),
		willAutoplay = isAutoplayEnabled() && inAutoplayCountries && !inFeaturedVideoClickToPlayABTest,
		slotTargeting = {
			plist: recommendedPlaylist,
			vtags: videoTags
		},
		responseTimeout = 2000,
		bidParams;

	function isFromRecirculation() {
		return window.location.search.indexOf('wikia-footer-wiki-rec') > -1;
	}

	function isAutoplayEnabled() {
		return featuredVideoCookieService.getAutoplay() !== '0';
	}

	function onPlayerReady(playerInstance) {
		define('wikia.articleVideo.featuredVideo.jwplayer.instance', function() {
			return playerInstance;
		});

		win.dispatchEvent(new CustomEvent('wikia.jwplayer.instanceReady', {detail: playerInstance}));

		trackingOptIn.pushToUserConsentQueue(function () {
			featuredVideoAds(playerInstance, bidParams, slotTargeting);
			featuredVideoMoatTracking.track(playerInstance);
		});

		playerInstance.on('autoplayToggle', function (data) {
			featuredVideoCookieService.setAutoplay(data.enabled ? '1' : '0');
		});

		playerInstance.on('captionsSelected', function (data) {
			featuredVideoCookieService.setCaptions(data.selectedLang);
		});

		// XW-4157 PageFair causes pausing the video, as a workaround we play video again when it's paused
		win.addEventListener('wikia.blocking', function () {
			if (playerInstance) {
				if (playerInstance.getState() === 'paused') {
					playerInstance.play();
				} else {
					playerInstance.once('pause', function (event) {
						// when video is paused because of PageFair pauseReason is undefined,
						// otherwise it's set to `interaction` when paused by user or `external` when paused by pause() function
						if (!event.pauseReason) {
							playerInstance.play();
						}
					});
				}
			}
		});
	}

	function setupPlayer() {
		featuredVideoMoatTracking.loadTrackingPlugin();
		win.wikiaJWPlayer('featured-video__player', {
			tracking: {
				track: function (data) {
					tracker.track(data);
				},
				setCustomDimension: win.guaSetCustomDimension,
				comscore: !win.wgDevelEnvironment
			},
			autoplay: willAutoplay,
			selectedCaptionsLanguage: featuredVideoCookieService.getCaptions(),
			settings: {
				showAutoplayToggle: !inFeaturedVideoClickToPlayABTest,
				showQuality: true,
				showCaptions: true
			},
			sharing: true,
			mute: isFromRecirculation() ? false : willAutoplay,
			related: {
				time: 3,
				playlistId: recommendedPlaylist,
				autoplay: inNextVideoAutoplayCountries
			},
			videoDetails: {
				description: videoDetails.description,
				title: videoDetails.title,
				playlist: videoDetails.playlist
			},
			logger: {
				clientName: 'oasis'
			},
			lang: videoDetails.lang
		}, onPlayerReady);
	}

	if (a9 && adContext.get('bidders.a9Video')) {
		a9.waitForResponseCallbacks(
			function onSuccess() {
				bidParams = a9.getSlotParams('FEATURED');
				setupPlayer();
			},
			function onTimeout() {
				bidParams = {};
				setupPlayer();
			},
			responseTimeout
		);
	} else {
		setupPlayer();
	}
});
