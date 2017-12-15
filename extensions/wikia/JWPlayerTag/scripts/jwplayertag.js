require([
	'jquery',
	'wikia.articleVideo.jwplayertag.ads',
	'wikia.tracker'
], function ($, videoAds, tracker) {
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
