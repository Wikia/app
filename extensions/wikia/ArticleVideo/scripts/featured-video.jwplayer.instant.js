require([
	'wikia.articleVideo.featuredVideo.jwplayer.instance',
	'wikia.articleVideo.featuredVideo.data',
	'wikia.articleVideo.featuredVideo.autoplay'
], function (playerInstance, videoDetails, featuredVideoAutoplay) {

	if (!videoDetails) {
		return;
	}

	var videoId = videoDetails.mediaId,
		inNextVideoAutoplayCountries = featuredVideoAutoplay.inNextVideoAutoplayCountries,
		willAutoplay = featuredVideoAutoplay.willAutoplay;

	function handleTabNotActive(willAutoplay) {
		var hidden,
			visibilityChange;

		if (typeof document.hidden !== "undefined") {
			hidden = "hidden";
			visibilityChange = "visibilitychange";
		} else if (typeof document.msHidden !== "undefined") {
			hidden = "msHidden";
			visibilityChange = "msvisibilitychange";
		} else if (typeof document.webkitHidden !== "undefined") {
			hidden = "webkitHidden";
			visibilityChange = "webkitvisibilitychange";
		}

		document.addEventListener(visibilityChange, function () {
			if (!document[hidden] && willAutoplay && playerInstance.getState() !== 'playing') {
				playerInstance.play(true);
			}
		}, false);
	}

	playerInstance.setup({
		file: "//content.jwplatform.com/videos/" + videoId + ".mp4",
		mediaid: videoId,
		autostart: willAutoplay && !document.hidden,
		mute: willAutoplay,
		image: "//content.jwplatform.com/thumbs/" + videoId + "-640.jpg",
		related: {
			file: "https://cdn.jwplayer.com/v2/playlists/Y2RWCKuS?related_media_id=" + videoId,
			oncomplete: inNextVideoAutoplayCountries ? 'autoplay' : 'show',
			autoplaytimer: 5
		},
		title: videoDetails.title,
		description: videoDetails.description
	});

	handleTabNotActive(willAutoplay);


});

