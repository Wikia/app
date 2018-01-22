require([
	'jquery',
	'wikia.articleVideo.jwplayertag.ads',
	'wikia.tracker',
	'wikia.articleVideo.featuredVideo.cookies'
], function ($, videoAds, tracker, featuredVideoCookieService) {
	'use strict';

	var parserTagSelector = '.jwplayer-in-article-video .jwplayer-container',
		jwVideoDataUrl = 'https://cdn.jwplayer.com/v2/media/';

	function init() {
		var parserTags = document.querySelectorAll(parserTagSelector);

		Array.prototype.slice.call(parserTags).forEach(function (each) {
			// We check this to avoid errors in places where we don't load JW
			// e.g. Monobook
			if (window.wikiaJWPlayer) {
				setupPlayer(each);
			}
		});
	}

	function onPlayerReady(playerInstance) {
		videoAds(playerInstance);

		playerInstance.on('captionsSelected', function (data) {
			featuredVideoCookieService.setCaptions(data.selectedLang);
		});
	}

	function getPlayerSetup(jwVideoData) {
		return {
			autoplay: false,
			tracking: {
				category: 'in-article-video',
				track: function (data) {
					tracker.track(data);
				}
			},
			selectedCaptionsLanguage: featuredVideoCookieService.getCaptions(),
			settings: {
				showAutoplayToggle: false,
				showQuality: true,
				showCaptions: true
			},
			videoDetails: {
				description: jwVideoData.description,
				title: jwVideoData.title,
				playlist: jwVideoData.playlist
			}
		};
	}

	function setupPlayer(videoParserTagElement) {
		fetchJWVideoData(videoParserTagElement.getAttribute('data-media-id'))
			.then(function (jwVideoData) {
				window.wikiaJWPlayer(
					videoParserTagElement.id,
					getPlayerSetup(jwVideoData),
					onPlayerReady
				);
			});
	}

	function fetchJWVideoData(mediaId) {
		return $.get(jwVideoDataUrl + mediaId);
	}

	init();
});
