require([
	'jquery',
	'wikia.tracker',
	'wikia.articleVideo.featuredVideo.cookies',
	'wikia.loader',
	'wikia.mustache'
], function ($, tracker, featuredVideoCookieService, loader, mustache) {
	'use strict';

	var jwPlaylistDataUrl = 'https://cdn.jwplayer.com/v2/playlists/',
		$unit = $('.article-recommended-video-unit'),
		scrollBreakpoint = 100,
		recommendedVideoElementId = 'recommendedVideo',
		recommendedVideoData = null,
		player = null,
		$actualVideo = null,
		currentItemNumber = 1,
		isEnabled = false,
		isExpanded = false,
		isAutoplay = false,
		initialPlay = true;

	function reveal() {
		tracker.track({
			category: 'related-video-module',
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.IMPRESSION,
			label: 'reveal-point'
		});

		if (!isEnabled) {
			return;
		}

		$unit.addClass('is-revealed');
		!isAutoplay && $unit.addClass('is-click-to-play');
		window.wikiaJWPlayer(
			recommendedVideoElementId,
			getPlayerSetup(recommendedVideoData),
			onPlayerReady
		);

		tracker.track({
			category: 'related-video-module',
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.VIEW,
			label: 'revealed'
		});
	}

	function onScroll() {
		var scrollTop = $(window).scrollTop();

		if (scrollTop > scrollBreakpoint) {
			window.setTimeout(reveal, 3000);
			window.document.removeEventListener('scroll', onScroll);
		}
	}

	function loadAssets() {
		loader({
			type: loader.MULTI,
			resources: {
				mustache: 'extensions/wikia/ArticleVideo/templates/ArticleVideo_recommendedVideos.mustache'
			}
		}).done(function (assets) {
			renderView(assets.mustache[0]);
			window.document.addEventListener('scroll', onScroll);
		});
	}

	function renderView(view) {
		// This is needed in order to access item index in mustache
		recommendedVideoData.playlist.forEach(function (video, index) {
			video.index = index;
		});
		$unit.find('.article-recommended-videos').html(
			mustache.render(view, {
				playlist: recommendedVideoData.playlist,
				firstVideo: recommendedVideoData.playlist[0]
			})
		);

		$actualVideo = $unit.find('.actual-video');
	}

	function onJWDataLoaded(videoElementId, jwPlayerData) {
		var shuffledPlaylist = jwPlayerData.playlist.sort(function () {
			return .5 - Math.random();
		});

		jwPlayerData.playlist = shuffledPlaylist.slice(0, 5);
		recommendedVideoData = jwPlayerData;
		recommendedVideoElementId = videoElementId;

		loadAssets();
	}

	function onCloseClicked() {
		$unit.removeClass('is-revealed');

		tracker.track({
			category: 'related-video-module',
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.CLICK,
			label: 'close'
		});

		setTimeout(function () {
			$unit.remove();
		}.bind(this), 300);
	}

	function playItem(data) {
		if (initialPlay && !isAutoplay) {
			initialPlay = false;
			return;
		}
		currentItemNumber = data.index + 1;

		$unit
			.removeClass('plays-video-1 plays-video-2 plays-video-3 plays-video-4 plays-video-5')
			.addClass('plays-video-' + currentItemNumber);

		$actualVideo.find('h3').html(data.item.title);

		tracker.track({
			category: 'related-video-module',
			trackingMethod: 'analytics',
			action: tracker.ACTIONS.VIEW,
			label: 'playlist-item-start'
		});
	}

	function init() {
		var isInClickToPlayGroup = window.Wikia.AbTest.inGroup('RECOMMENDED_VIDEO_AB', 'CLICK_TO_PLAY');

		isAutoplay = window.Wikia.AbTest.inGroup('RECOMMENDED_VIDEO_AB', 'AUTOPLAY');
		isEnabled = isAutoplay || isInClickToPlayGroup;

		if ($unit.length && window.wikiaJWPlayer) {
			setupPlayer();
		}

		$unit.find('.article-recommended-video-unit__close-button').on('click', onCloseClicked);
	}

	function onPlayerReady(playerInstance) {
		player = playerInstance;

		bindPlayerEvents(playerInstance);

		if (isAutoplay) {
			$unit.addClass('plays-video-1');
		}
	}

	function bindPlayerEvents(playerInstance) {
		playerInstance.on('playlistItem', playItem);

		isAutoplay && playerInstance.once('mute', function () {
			playExpandedItem(currentItemNumber - 1);
		});

		isAutoplay && playerInstance.on('play', function (data) {
			if (data.playReason === 'interaction' && isExpanded !== true) {
				playExpandedItem(currentItemNumber - 1);
			}
		});

		playerInstance.on('captionsSelected', function (data) {
			featuredVideoCookieService.setCaptions(data.selectedLang);
		});

		$unit.find('.video-placeholder').on('click', function () {
			playExpandedItem($(this).data('index'));

			tracker.track({
				category: 'related-video-module',
				trackingMethod: 'analytics',
				action: tracker.ACTIONS.CLICK,
				label: 'playlist-item'
			});
		});

		$unit.find('.article-recommended-video-title').on('click', function () {
			playExpandedItem(currentItemNumber - 1);

			tracker.track({
				category: 'related-video-module',
				trackingMethod: 'analytics',
				action: tracker.ACTIONS.CLICK,
				label: 'playlist-item'
			});
		});
	}

	function playExpandedItem(index) {
		var currentIndex = player.getPlaylistItem().index;

		if (!isAutoplay || currentIndex !== index) {
			player.playlistItem(index);
			player.play();
		}

		expand();
	}

	function getPlayerSetup(jwVideoData) {
		return {
			autoplay: isAutoplay,
			tracking: {
				category: 'related-video-module',
				track: function (data) {
					tracker.track(data);
				}
			},
			selectedCaptionsLanguage: featuredVideoCookieService.getCaptions(),
			settings: {
				showQuality: true,
				showCaptions: true
			},
			showSmallPlayerControls: true,
			videoDetails: {
				description: jwVideoData.description,
				title: jwVideoData.title,
				playlist: jwVideoData.playlist
			},
			playerUrl: 'https://content.jwplatform.com/libraries/h6Nc84Oe.js',
			repeat: true,
			mute: true
		};
	}

	function setupPlayer() {
		fetchJWVideoData($unit.data('playlistId'), $unit.data('relatedMediaId'))
			.done(function (jwVideoData) {
				onJWDataLoaded(recommendedVideoElementId, jwVideoData);
			});
	}

	function fetchJWVideoData(mediaId, relatedMediaId) {
		var deferred = $.Deferred();

		$.get(jwPlaylistDataUrl + mediaId + '?related_media_id=' + relatedMediaId).then(function (data) {
			deferred.resolve(data);
		}).fail(function () {{
			$.get(jwPlaylistDataUrl + mediaId).then(function (data) {
				deferred.resolve(data);
			});
		}});

		return deferred.promise();
	}

	function expand() {
		if (!isExpanded) {
			$unit.addClass('is-expanded');

			isExpanded = true;

			tracker.track({
				category: 'related-video-module',
				trackingMethod: 'analytics',
				action: tracker.ACTIONS.VIEW,
				label: 'expanded'
			});

			player.setMute(false);

			// Needed to trigger jwplayer breakpoint change
			setTimeout(function () {
				player.resize();
			}, 100);
		}
	}

	init();
});
