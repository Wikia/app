require([
	'wikia.cookies',
	'wikia.geo',
	'wikia.instantGlobals',
	'jwplayer.instance',
	'wikia.featuredVideoData'
], function (cookies, geo, instantGlobals, playerInstance, videoDetails) {

	if (!videoDetails) {
		return;
	}

	var videoId = videoDetails.videoId,
		inAutoplayCountries = geo.isProperGeo(instantGlobals.wgArticleVideoAutoplayCountries),
		inNextVideoAutoplayCountries = geo.isProperGeo(instantGlobals.wgArticleVideoNextVideoAutoplayCountries),
		autoplayCookieName = 'featuredVideoAutoplay',
		willAutoplay = cookies.get(autoplayCookieName) !== '0' && inAutoplayCountries;

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

	if (inAutoplayCountries) {
		function addAutoplayToggleButton () {
			playerInstance.addButton(
				"<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" class='wds-icon'>\n" +
				"<path fill-rule=\"evenodd\" d=\"M23.905 21.84a.775.775 0 0 1-.018.777.802.802 0 0 1-.686.383H.8a.804.804 0 0 1-.688-.383.775.775 0 0 1-.017-.777l11.2-20.458c.28-.51 1.13-.51 1.41 0l11.2 20.458zM11 8.997v6.006c0 .544.448.997 1 .997.556 0 1-.446 1-.997V8.997C13 8.453 12.552 8 12 8c-.556 0-1 .446-1 .997zM11 19c0 .556.448 1 1 1 .556 0 1-.448 1-1 0-.556-.448-1-1-1-.556 0-1 .448-1 1z\"/>\n" +
				"</svg>",
				"Toggle Autoplay",
				function () {
					cookies.set(autoplayCookieName, cookies.get(autoplayCookieName) === '0' ? '1' : '0');

					console.log('autoplay', cookies.get(autoplayCookieName))
				},
				"autoplayToggle"
			);
		}

		addAutoplayToggleButton();

		playerInstance.on('resize', function (event) {
			if (event.width < 600) {
				playerInstance.removeButton('autoplayToggle');
			} else {
				addAutoplayToggleButton();
			}
		})
	}
});

