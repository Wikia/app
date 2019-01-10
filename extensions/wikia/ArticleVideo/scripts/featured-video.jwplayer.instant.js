require([
	'wikia.window',
	'wikia.cookies',
	'wikia.document',
	'wikia.tracker',
	'wikia.trackingOptIn',
	'wikia.abTest',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.hmdRecLoader',
	'wikia.articleVideo.featuredVideo.data',
	'wikia.articleVideo.featuredVideo.autoplay',
	'wikia.articleVideo.featuredVideo.adsConfiguration',
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine.lookup.bidders')
], function (
	win,
	cookies,
	doc,
	tracker,
	trackingOptIn,
	abTest,
	adContext,
	hmdRecLoader,
	videoDetails,
	featuredVideoAutoplay,
	featuredVideoAds,
	featuredVideoCookieService,
	bidders
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

		featuredVideoAds.init(playerInstance, bidParams, slotTargeting);

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

		featuredVideoAds.trackSetup(videoDetails.playlist[0].mediaid, willAutoplay, willMute);

		featuredVideoAds.loadMoatTrackingPlugin();
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

	trackingOptIn.pushToUserConsentQueue(function () {
		if (adContext.get('opts.babDetectionDesktop')) {
			doc.addEventListener('bab.blocking', function () {
				if (adContext.get('opts.wadHMD')) {
					hmdRecLoader.setOnReady(function () {
						setupPlayer();
					});
				} else {
					setupPlayer();
				}
			});

			doc.addEventListener('bab.not_blocking', function () {
				if (bidders && bidders.isEnabled()) {
					bidders.runOnBiddingReady(function () {
						bidParams = bidders.updateSlotTargeting(featuredVideoSlotName);
						setupPlayer();
					});
				} else {
					setupPlayer();
				}
			});
		} else {
			setupPlayer();
		}
	});
});
