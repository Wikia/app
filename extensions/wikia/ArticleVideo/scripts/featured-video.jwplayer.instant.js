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
	'wikia.articleVideo.featuredVideo.session',
	'wikia.geo',
	require.optional('ext.wikia.adEngine3.api'),
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
	featuredVideoSession,
	geo,
	adsApi,
) {
	var allowedPlayerImpressionsPerSession = videoDetails.impressionsPerSession || 1,
		hasVideoOnPage = null;

	win.canPlayVideo = function () {
		if (hasVideoOnPage === null) {
			hasVideoOnPage = videoDetails && (
				videoDetails.isDedicatedForArticle ||
				(isVideoBridgeAllowedForCountry() &&
					!featuredVideoSession.hasMaxedOutPlayerImpressionsInWiki(allowedPlayerImpressionsPerSession))
			);
		}

		return hasVideoOnPage;
	};

	if (!win.canPlayVideo()) {
		doc.body.classList.add('no-featured-video');
		return;
	}

	//Fallback to the generic playlist when no recommended videos playlist is set for the wiki
	var recommendedPlaylist = videoDetails.recommendedVideoPlaylist || 'Y2RWCKuS',
		videoTags = videoDetails.videoTags || '',
		slotTargeting = {
			plist: recommendedPlaylist,
			vtags: videoTags,
			videoScope: videoDetails.isDedicatedForArticle ? 'article' : 'wiki'
		},
		videoOptions;

	function extend(target, obj) {
		var key;

		for (key in obj) {
			target[key] = obj[key];
		}

		return target;
	}

	function isFromRecirculation() {
		return window.location.search.indexOf('wikia-footer-wiki-rec') > -1;
	}

	function shouldForceUserIntendedPlay() {
		return isFromRecirculation();
	}

	function onPlayerReady(playerInstance) {
		if (!videoDetails.isDedicatedForArticle) {
			featuredVideoSession.setVideoSeenInSession();
		}

		define('wikia.articleVideo.featuredVideo.jwplayer.instance', function() {
			return playerInstance;
		});

		win.dispatchEvent(new CustomEvent('wikia.jwplayer.instanceReady', {detail: playerInstance}));

		if (videoOptions) {
			var playerKey = 'aeJWPlayerKey';

			window[playerKey] = playerInstance;

			adsApi.dispatchPlayerReady(videoOptions, slotTargeting, playerKey);
		}

		playerInstance.on('autoplayToggle', function (data) {
			featuredVideoCookieService.setAutoplay(data.enabled ? '1' : '0');
		});

		playerInstance.on('captionsSelected', function (data) {
			featuredVideoCookieService.setCaptions(data.selectedLang);
		});
	}

	function setupPlayer(showAds, adEngineAutoplayDisabled) {
		var willAutoplay = featuredVideoAutoplay.isAutoplayEnabled(adEngineAutoplayDisabled),
			willMute = isFromRecirculation() ? false : willAutoplay;

		if (adsApi && showAds) {
			videoOptions = {
				adProduct: 'featured',
				slotName: 'featured',
				audio: !willMute,
				autoplay: willAutoplay,
				featured: true,
				videoId: videoDetails.playlist[0].mediaid,
			};
		}
		configurePlayer(willAutoplay, willMute, adEngineAutoplayDisabled);

	}

	function configurePlayer(willAutoplay, willMute, adEngineAutoplayDisabled) {
		var videoScope = videoDetails.isDedicatedForArticle ? 'article' : 'wiki';

		win.guaSetCustomDimension(30, videoScope);

		win.wikiaJWPlayer('featured-video__player', {
			tracking: {
				track: function (data) {
					tracker.track(extend(data, { videoScope: videoScope }));
				},
				setCustomDimension: win.guaSetCustomDimension,
				comscore: !win.wgDevelEnvironment
			},
			autoplay: willAutoplay,
			selectedCaptionsLanguage: featuredVideoCookieService.getCaptions(),
			settings: {
				showAutoplayToggle: featuredVideoAutoplay.isAutoplayToggleShown(adEngineAutoplayDisabled),
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
				playlist: getModifiedPlaylist(videoDetails.playlist, videoDetails.isDedicatedForArticle)
			},
			logger: {
				clientName: 'oasis'
			},
			lang: videoDetails.lang,
			shouldForceUserIntendedPlay: shouldForceUserIntendedPlay()
		}, onPlayerReady);
	}

	function getModifiedPlaylist(playlist, isDedicatedForArticle) {
		var normalizedPlaylistIndex = getNormalizedPlaylistIndex(playlist);
		var newPlaylist = playlist.slice(normalizedPlaylistIndex);

		return (!isDedicatedForArticle && newPlaylist.length) ? newPlaylist : playlist;
	}

	function getNormalizedPlaylistIndex(playlist) {
		var playerImpressions = featuredVideoCookieService.getPlayerImpressionsInWiki() || 0;

		return playerImpressions > playlist.length ? playerImpressions % playlist.length : playerImpressions;
	}

	function isVideoBridgeAllowedForCountry() {
		var countryCode = geo.getCountryCode().toLowerCase();
		var allowedCountries = (window.wgVideoBridgeCountries || []).map(function (allowedCountryCode) {
			return allowedCountryCode.toLowerCase();
		});

		return countryCode && allowedCountries.indexOf(countryCode) !== -1;
	}

	trackingOptIn.pushToUserConsentQueue(function () {
		if (adsApi) {
			return adsApi.listenSetupJWPlayer(function (action) {
				setupPlayer(action.showAds, action.autoplayDisabled);
			});
		}

        setupPlayer(false, false);
	});
});
