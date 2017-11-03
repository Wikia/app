require(['jquery'], function ($) {
	var parserTagClassName = 'jw-player-in-article-video',
		jwVideoDataUrl = 'https://cdn.jwplayer.com/v2/media/';

	function init() {
		var parserTags = document.getElementsByClassName(parserTagClassName);

		Array.prototype.slice.call(parserTags).forEach(function (each) {
			if (window.WikiaJWPlayer) {
				setupPlayer(each);
			}
		});
	}

	function getPlayerSetup(jwVideoData) {
		return {
			autoplay: {
				enabled: false
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
				console.log(jwVideoData);
				window.wikiaJWPlayer(
					videoParserTagElement.id,
					getPlayerSetup(jwVideoData)
				)
			});
	}

	function fetchJWVideoData(mediaId) {
		return $.get(jwVideoDataUrl + mediaId);
	}

	init();
});
