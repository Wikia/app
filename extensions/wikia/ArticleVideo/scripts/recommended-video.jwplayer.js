require([
	'jquery',
	'wikia.tracker',
	'wikia.articleVideo.featuredVideo.cookies'
], function ($, tracker, featuredVideoCookieService) {
	'use strict';

	var recommendedVideoSelector = '.article-recommended-video .video',
		jwVideoDataUrl = 'https://cdn.jwplayer.com/v2/media/',
		windowHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0),
		$unit = $('.article-recommended-video-unit'),
		currentVideo = null;

	function onScroll() {
		var scrollTop = $(window).scrollTop();

		if (scrollTop > windowHeight * 1.5) {
			$unit.addClass('revealed');
			document.removeEventListener('scroll', onScroll);
		}
	}

	function onCloseClicked() {
		$unit.removeClass('revealed');
	}

	function init() {
		var recommendedVideo = document.querySelector(recommendedVideoSelector);

		if (recommendedVideo && window.wikiaJWPlayer) {
			setupPlayer(recommendedVideo);
		}

		document.addEventListener('scroll', onScroll);
		$unit.find('.article-recommended-video-unit__close-button').on('click', onCloseClicked);
	}

	function onPlayerReady(playerInstance) {
		playerInstance.on('captionsSelected', function (data) {
			featuredVideoCookieService.setCaptions(data.selectedLang);
		});
	}

	function getPlayerSetup(jwVideoData) {
		return {
			autoplay: true,
			tracking: {
				category: 'article-recommended-video',
				track: function (data) {
					tracker.track(data);
				}
			},
			selectedCaptionsLanguage: featuredVideoCookieService.getCaptions(),
			settings: {
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

	function setupPlayer(recommendedVideoElement) {
		fetchJWVideoData(recommendedVideoElement.getAttribute('data-media-id'))
			.then(function (jwVideoData) {
				window.wikiaJWPlayer(
					recommendedVideoElement.id,
					getPlayerSetup(jwVideoData),
					onPlayerReady
				);
			});
	}

	function fetchJWVideoData(mediaId) {
		return $.get(jwVideoDataUrl + mediaId);
	}

	function expand(videoContainer) {
		$unit.addClass('expanded');

	}

	init();
});
