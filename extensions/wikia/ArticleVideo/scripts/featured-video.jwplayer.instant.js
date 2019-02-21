require([
	'wikia.window',
	'wikia.cookies',
	'wikia.document',
	'wikia.tracker',
	'wikia.trackingOptIn',
	'wikia.abTest',
	'wikia.articleVideo.featuredVideo.data',
	'wikia.articleVideo.featuredVideo.autoplay',
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine.adContext'),
	require.optional('ext.wikia.adEngine.lookup.bidders'),
	require.optional('ext.wikia.adEngine.wad.hmdRecLoader'),
	require.optional('ext.wikia.adEngine3.api'),
	require.optional('wikia.articleVideo.featuredVideo.adsConfiguration'),
], function (
	win,
	cookies,
	doc,
	tracker,
	trackingOptIn,
	abTest,
	videoDetails,
	featuredVideoAutoplay,
	featuredVideoCookieService,
	adContext,
	bidders,
	hmdRecLoader,
	adsApi,
	featuredVideoAds,
) {
	if (!videoDetails) {
		return;
	}

	//Fallback to the generic playlist when no recommended videos playlist is set for the wiki
	var recommendedPlaylist = videoDetails.recommendedVideoPlaylist || 'Y2RWCKuS',
		videoTags = videoDetails.videoTags || '',
		featuredVideoSlotName = 'FEATURED',
		slotTargeting = {
			plist: recommendedPlaylist,
			vtags: videoTags
		},
		videoAds,
		bidParams;

	function isFromRecirculation() {
		return window.location.search.indexOf('wikia-footer-wiki-rec') > -1;
	}

	function shouldForceUserIntendedPlay() {
		return isFromRecirculation();
	}

	function onPlayerReady(playerInstance) {
		define('wikia.articleVideo.featuredVideo.jwplayer.instance', function() {
			return playerInstance;
		});

		win.dispatchEvent(new CustomEvent('wikia.jwplayer.instanceReady', {detail: playerInstance}));

		if (featuredVideoAds && !adsApi) {
			featuredVideoAds.init(playerInstance, bidParams, slotTargeting);
		} else if (videoAds) {
			videoAds.register(playerInstance, slotTargeting);
		}

		playerInstance.on('autoplayToggle', function (data) {
			featuredVideoCookieService.setAutoplay(data.enabled ? '1' : '0');
		});

		playerInstance.on('captionsSelected', function (data) {
			featuredVideoCookieService.setCaptions(data.selectedLang);
		});
	}

	function setupPlayer() {
		var willAutoplay = featuredVideoAutoplay.isAutoplayEnabled(),
			willMute = isFromRecirculation() ? false : willAutoplay;

		if (featuredVideoAds && !adsApi) {
			featuredVideoAds.trackSetup(videoDetails.playlist[0].mediaid, willAutoplay, willMute);
			featuredVideoAds.loadMoatTrackingPlugin();
		}

		if (adsApi && adsApi.shouldShowAds()) {
			videoAds = adsApi.jwplayerAdsFactory.create({
				adProduct: 'featured',
				slotName: 'featured',
				audio: !willMute,
				autoplay: willAutoplay,
				featured: true,
				videoId: videoDetails.playlist[0].mediaid,
			});
			adsApi.jwplayerAdsFactory.loadMoatPlugin();
		}

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
				showAutoplayToggle: featuredVideoAutoplay.isAutoplayToggleShown(),
				showQuality: true,
				showCaptions: true
			},
			sharing: true,
			mute: willMute,
			related: {
				time: 3,
				playlistId: recommendedPlaylist,
				autoplay: featuredVideoAutoplay.inNextVideoAutoplayEnabled()
			},
			videoDetails: {
				description: videoDetails.description,
				title: videoDetails.title,
				playlist: videoDetails.playlist
			},
			logger: {
				clientName: 'oasis'
			},
			lang: videoDetails.lang,
			shouldForceUserIntendedPlay: shouldForceUserIntendedPlay()
		}, onPlayerReady);
	}

	function prePlayerSetup(blocking) {
		if (blocking && adContext.get('opts.wadHMD')) {
			hmdRecLoader.setOnReady(function () {
				setupPlayer();
			});

			return;
		}

		if (!blocking && bidders && bidders.isEnabled()) {
			bidders.runOnBiddingReady(function () {
				bidParams = bidders.updateSlotTargeting(featuredVideoSlotName);
				setupPlayer();
			});

			return;
		}

		setupPlayer();
	}

	trackingOptIn.pushToUserConsentQueue(function () {
		if (adsApi) {
			adsApi.waitForAdStackResolve().then(setupPlayer);

			return;
		}

		if (!adContext || !adContext.get('opts.showAds')) {
			setupPlayer();

			return;
		}

		if (!hmdRecLoader || !adContext.get('opts.babDetectionDesktop')) {
			prePlayerSetup(false);
		} else {
			doc.addEventListener('bab.blocking', function () {
				prePlayerSetup(true);
			});

			doc.addEventListener('bab.not_blocking', function () {
				prePlayerSetup(false);
			});
		}
	});
});
