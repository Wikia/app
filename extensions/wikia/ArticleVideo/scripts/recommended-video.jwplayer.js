require([
	'jquery',
	'wikia.tracker',
	'wikia.articleVideo.featuredVideo.cookies',
	'wikia.loader',
	'wikia.mustache'
], function ($, tracker, featuredVideoCookieService, loader, mustache) {
	'use strict';

	var recommendedVideoSelector = '.article-recommended-video .video',
		jwPlaylistDataUrl = 'https://cdn.jwplayer.com/v2/playlists/',
		windowHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0),
		$unit = $('.article-recommended-video-unit'),
		currentVideo = null,
		recommendedVideoElementId = 'recommendedVideo',
		recommendedVideoData = null,
		player = null,
		$actualVideo = null;

	function onScroll() {
		var scrollTop = $(window).scrollTop();

		if (scrollTop > windowHeight * 1.5) {
			$unit.addClass('revealed');
			window.wikiaJWPlayer(
				recommendedVideoElementId,
				getPlayerSetup(recommendedVideoData),
				onPlayerReady
			);

			document.removeEventListener('scroll', onScroll);
		}
	}

	function loadAssets() {
		loader({
			type: loader.MULTI,
			resources: {
				mustache: 'extensions/wikia/ArticleVideo/templates/ArticleVideo_recommendedVideos.mustache',
			}
		}).done(function (assets) {
			renderView(assets.mustache[0]);
			document.addEventListener('scroll', onScroll);
		});
	}

	function renderView(view) {
		$unit.find('.article-recommended-videos').html(
			mustache.render(view, {
				playlist: recommendedVideoData.playlist,
				firstVideo: recommendedVideoData.playlist[0]
			})
		);

		$actualVideo = $unit.find('.actual-video');
	}

	function onJWDataLoaded(videoElementId, jwPlayerData) {
		recommendedVideoData = jwPlayerData;
		recommendedVideoElementId = videoElementId;

		loadAssets();
	}

	function onCloseClicked() {
		$unit.removeClass('revealed');
	}

	function playItem(data) {
		var itemNumber = data.index + 1;

		$unit
			.removeClass('plays-video-1 plays-video-2 plays-video-3 plays-video-4 plays-video-5')
			.addClass('plays-video-' + itemNumber);

		$actualVideo.find('h3').html(data.item.title);
	}

	function init() {
		if ($unit && window.wikiaJWPlayer) {
			setupPlayer();
		}

		$unit.find('.article-recommended-video-unit__close-button').on('click', onCloseClicked);
	}

	function onPlayerReady(playerInstance) {
		playerInstance.on('captionsSelected', function (data) {
			featuredVideoCookieService.setCaptions(data.selectedLang);
		});

		player = playerInstance;

		bindPlayerEvents(playerInstance);
	}

	function bindPlayerEvents(playerInstance) {
		playerInstance.on('playlistItem', playItem);
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
			},
			playerUrl: 'https://content.jwplatform.com/libraries/h6Nc84Oe.js'
		};
	}

	function setupPlayer() {
		fetchJWVideoData($unit.data('playlistId'))
			.then(function (jwVideoData) {
				onJWDataLoaded(recommendedVideoElementId, jwVideoData);
			});
	}

	function fetchJWVideoData(mediaId) {
		return $.get(jwPlaylistDataUrl + mediaId);
	}

	function expand(videoContainer) {
		$unit.addClass('expanded');
	}

	init();
});
