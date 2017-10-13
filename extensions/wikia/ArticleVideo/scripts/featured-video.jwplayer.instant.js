require([
	'ext.wikia.adEngine.adContext',
	'wikia.articleVideo.featuredVideo.jwplayer.instance',
	'wikia.articleVideo.featuredVideo.data',
	'wikia.articleVideo.featuredVideo.ads',
	'wikia.articleVideo.featuredVideo.autoplay',
	'wikia.articleVideo.featuredVideo.tracking',
	require.optional('ext.wikia.adEngine.lookup.a9')
], function (
	adContext,
	playerInstance,
	videoDetails,
	featuredVideoAds,
	featuredVideoAutoplay,
	featuredVideoTracking,
	a9
) {
	if (!videoDetails) {
		return;
	}

	var videoId = videoDetails.mediaId,
		inNextVideoAutoplayCountries = featuredVideoAutoplay.inNextVideoAutoplayCountries,
		//Fallback to the generic playlist when no recommended videos playlist is set for the wiki
		recommendedPlaylist = videoDetails.recommendedVideoPlaylist || 'Y2RWCKuS',
		willAutoplay = featuredVideoAutoplay.willAutoplay;

	function handleTabNotActive(willAutoplay) {
		document.addEventListener('visibilitychange', function () {
			if (canPlayVideo(willAutoplay)) {
				playerInstance.play(true);
			}
		}, false);
	}

	function canPlayVideo(willAutoplay) {
		return !document.hidden && willAutoplay && ['playing', 'paused'].indexOf(playerInstance.getState()) === -1;
	}

	function setupPlayer(bidParams) {
		playerInstance.setup({
			advertising: {
				client: 'googima'
			},
			autostart: willAutoplay && !document.hidden,
			description: videoDetails.description,
			image: '//content.jwplatform.com/thumbs/' + videoId + '-640.jpg',
			mute: willAutoplay,
			playlist: videoDetails.playlist,
			related: {
				autoplaytimer: 5,
				file: 'https://cdn.jwplayer.com/v2/playlists/'+ recommendedPlaylist +'?related_media_id=' + videoId,
				oncomplete: inNextVideoAutoplayCountries ? 'autoplay' : 'show'
			},
			title: videoDetails.title
		});

		featuredVideoAds(playerInstance, bidParams);
		featuredVideoTracking(playerInstance, willAutoplay);
		handleTabNotActive(willAutoplay);
	}

	if (a9 && adContext.get('bidders.a9Video')) {
		a9.waitForResponse()
			.then(function () {
				return a9.getSlotParams('FEATURED');
			})
			.catch(function () {
				return {};
			})
			.then(function (bidParams) {
				setupPlayer(bidParams);
			});
	} else {
		setupPlayer();
	}
});
