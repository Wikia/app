require([
	'wikia.articleVideo.featuredVideo.jwplayer.instance',
	'wikia.articleVideo.featuredVideo.data',
	'wikia.articleVideo.featuredVideo.autoplay',
	'wikia.articleVideo.featuredVideo.tracking'
], function (
	playerInstance,
	videoDetails,
	featuredVideoAutoplay,
	featuredVideoTracking
) {
	if (!videoDetails) {
		return;
	}

	var videoId = videoDetails.mediaId,
		inNextVideoAutoplayCountries = featuredVideoAutoplay.inNextVideoAutoplayCountries,
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

	//Fallback to the generic playlist when no recommended videos playlist is set for the wiki
	var recommendedPlaylist = videoDetails.recommendedVideoPlaylist || 'Y2RWCKuS';

	playerInstance.setup({
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

	featuredVideoTracking(playerInstance, willAutoplay);
	handleTabNotActive(willAutoplay);
});
