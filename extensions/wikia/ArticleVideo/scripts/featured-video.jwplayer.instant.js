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
		var hidden,
			visibilityChangeEvent;

		if (typeof document.hidden !== 'undefined') {
			hidden = "hidden";
			visibilityChangeEvent = 'visibilitychange';
		} else if (typeof document.msHidden !== "undefined") {
			hidden = "msHidden";
			visibilityChangeEvent = 'msvisibilitychange';
		} else if (typeof document.webkitHidden !== "undefined") {
			hidden = "webkitHidden";
			visibilityChangeEvent = 'webkitvisibilitychange';
		}

		if (visibilityChangeEvent) {
			document.addEventListener(visibilityChangeEvent, function () {
				if (canPlayVideo(hidden, willAutoplay)) {
					playerInstance.play(true);
				}
			}, false);
		}
	}

	function canPlayVideo(hidden, willAutoplay) {
		return !document[hidden] && willAutoplay && ['playing', 'paused'].indexOf(playerInstance.getState()) === -1;
	}

	playerInstance.setup({
		autostart: willAutoplay && !document.hidden,
		description: videoDetails.description,
		image: "//content.jwplatform.com/thumbs/" + videoId + "-640.jpg",
		mute: willAutoplay,
		playlist: videoDetails.playlist,
		related: {
			autoplaytimer: 5,
			file: "https://cdn.jwplayer.com/v2/playlists/Y2RWCKuS?related_media_id=" + videoId,
			oncomplete: inNextVideoAutoplayCountries ? 'autoplay' : 'show'
		},
		title: videoDetails.title
	});

	featuredVideoTracking(playerInstance, willAutoplay);
	handleTabNotActive(willAutoplay);
});
