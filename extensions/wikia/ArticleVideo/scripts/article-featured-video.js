require([
	'wikia.window',
	'wikia.onScroll',
	'wikia.tracker',
	'ooyala-player',
	'wikia.abTest',
	'wikia.articleVideo.videoFeedbackBox',
	require.optional('ext.wikia.adEngine.adContext'),
	require.optional('ext.wikia.adEngine.video.player.ooyala.ooyalaTracker'),
	require.optional('ext.wikia.adEngine.video.vastUrlBuilder')
], function (
	window,
	onScroll,
	tracker,
	OoyalaPlayer,
	abTest,
	VideoFeedbackBox,
	adContext,
	playerTracker,
	vastUrlBuilder
) {

	$(function () {
		var $video = $('#article-video'),
			$videoContainer = $video.find('.video-container'),
			$videoThumbnail = $videoContainer.find('.video-thumbnail'),
			$closeBtn = $videoContainer.find('.close'),
			ooyalaVideoController,
			ooyalaVideoElementId = 'ooyala-article-video',
			$ooyalaVideo = $('#' + ooyalaVideoElementId),
			videoCollapsed = false,
			collapsingDisabled = false,
			playTime = -1,
			percentagePlayTime = -1,
			prerollSlotName = 'FEATURED_VIDEO',
			playerTrackerParams = {
				adProduct: 'featured-video',
				slotName: prerollSlotName
			},
			track = tracker.buildTrackingFunction({
				category: 'article-video',
				trackingMethod: 'analytics'
			}),
			collapsedVideoSize = {
				width: 300,
				height: 169
			},
			videoFeedbackBox;

		function initVideo(onCreate) {
			var ooyalaVideoId = window.wgFeaturedVideoId,
				playerParams = window.wgOoyalaParams,
				autoplay = abTest.inGroup('FEATURED_VIDEO_AUTOPLAY', 'AUTOPLAY') && window.OO.allowAutoPlay,
				vastUrl;

			if (playerTracker) {
				playerTracker.track(playerTrackerParams, 'init');
			}

			if (vastUrlBuilder && adContext && adContext.getContext().opts.showAds) {
				vastUrl = vastUrlBuilder.build(640/480, {
					pos: prerollSlotName,
					src: 'premium'
				});
			}

			ooyalaVideoController = OoyalaPlayer.initHTML5Player(
				ooyalaVideoElementId,
				playerParams,
				ooyalaVideoId,
				onCreate,
				autoplay,
				vastUrl
			);
		}

		function collapseVideo(videoOffset, videoHeight) {
			var videoWidth = $video.outerWidth(),
				viewportWidth = $(window).width(),
				viewportHeight = $(window).height();

			collapsingDisabled = false;
			videoCollapsed = true;
			$video.addClass('is-collapsed-ready');
			if (ooyalaVideoController) {
				updatePlayerControls(true);
			}
			$videoContainer.css({
				'bottom': viewportHeight - videoOffset.top - videoHeight + $(window).scrollTop(),
				'right': viewportWidth - videoOffset.left - videoWidth,
				'width': videoWidth
			});
			$videoThumbnail.css('height', videoHeight);
			$ooyalaVideo.css('height', videoHeight);
			setTimeout(function () {
				if (videoCollapsed) { // we need to be sure video has not been uncollapsed yet
					$video.addClass('is-collapsed');
				}
			}, 0);
		}

		function uncollapseVideo() {
			videoCollapsed = false;
			$videoContainer.css({
				'position': '',
				'bottom': '',
				'right': '',
				'top': '',
				'left': '',
				'width': ''
			});
			$videoThumbnail.css('height', '');
			$ooyalaVideo.css('height', '');
			$video.removeClass('is-collapsed is-collapsed-ready');
			if (ooyalaVideoController) {
				updatePlayerControls(false);
			}

		}

		function closeButtonClicked(event) {
			event.stopPropagation();
			if (ooyalaVideoController && ooyalaVideoController.player) {
				ooyalaVideoController.player.pause();
			}
			uncollapseVideo();
			collapsingDisabled = true;
			track({
				action: tracker.ACTIONS.CLOSE,
				label: 'featured-video-collapsed'
			});
		}

		function updateOoyalaSize() {
			// we have to trigger resize event to make html5-skin resize controls
			window.dispatchEvent(new Event('resize'));
			// wait for player resize - there is 150ms debounce on resize event in ooyala html5-skin
			setTimeout(function () {
				ooyalaVideoController.showControls();
			}, 200);
		}

		function updatePlayerControls(waitForTransition) {
			ooyalaVideoController.hideControls();
			if (!waitForTransition) {
				updateOoyalaSize();
			}
			// otherwise wait for SIZE_CHANGED event and then execute updateOoyalaSize function only if video width
			// is equal to $collapsedVideoSize.width - so updateOoyalaSize won't be executed twice
		}

		function isVideoInFullScreenMode() {
			if (ooyalaVideoController && ooyalaVideoController.player) {
				// isFullscreen() returns false just faster switching to fullscreen mode so we also
				// check webkitIsFullScreen property - that's only for Safari
				return ooyalaVideoController.player.isFullscreen() || document.webkitIsFullScreen;
			}
			return false;
		}

		function toggleCollapse() {
			// That's for Safari because it triggers scroll event (it scrolls to the top)
			// when video is switched to full screen mode.
			if (isVideoInFullScreenMode()) {
				return;
			}
			if (!collapsingDisabled || videoCollapsed) {
				var scrollTop = $(window).scrollTop(),
					videoHeight = $video.outerHeight(),
					videoOffset = $video.offset(),
					scrollOffset = 100,
					collapseOffset = videoOffset.top + videoHeight - scrollOffset;

				if (scrollTop > collapseOffset && !videoCollapsed) {
					collapseVideo(videoOffset, videoHeight);
				} else if (scrollTop <= collapseOffset && videoCollapsed) {
					uncollapseVideo();
				}
			}
		}

		function initAttributionTracking() {
			$('.featured-video__attribution-container a').click(function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'attribution'
				});
			});
		}

		initVideo(function (player) {
			$video.addClass('ready-to-play');

			if (playerTracker) {
				playerTracker.register(player, playerTrackerParams);
			}

			player.mb.subscribe(OO.EVENTS.INITIAL_PLAY, 'featured-video', function () {
				track({
					action: tracker.ACTIONS.PLAY_VIDEO,
					label: 'featured-video'
				});
			});

			player.mb.subscribe(OO.EVENTS.VOLUME_CHANGED, 'featured-video', function (eventName, volume) {
				if (volume > 0) {
					track({
						action: tracker.ACTIONS.CLICK,
						label: 'featured-video-unmuted'
					});
					player.mb.unsubscribe(OO.EVENTS.VOLUME_CHANGED, 'featured-video');
				}
			});

			player.mb.subscribe(OO.EVENTS.PLAY, 'featured-video', function () {
				collapsingDisabled = false;
				if (videoFeedbackBox) {
					videoFeedbackBox.show();
				}
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-play'
				});
			});

			player.mb.subscribe(OO.EVENTS.PLAYED, 'featured-video', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-played'
				});
			});

			player.mb.subscribe(OO.EVENTS.PAUSED, 'featured-video', function () {
				if (videoFeedbackBox) {
					videoFeedbackBox.hide();
				}
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-paused'
				});
			});

			player.mb.subscribe(window.OO.EVENTS.SIZE_CHANGED, 'featured-video', function (eventName, width) {
				if (width === collapsedVideoSize.width) {
					updateOoyalaSize();
				}
			});

			player.mb.subscribe(window.OO.EVENTS.REPLAY, 'featured-video', function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-replay'
				});
			});

			player.mb.subscribe(window.OO.EVENTS.PLAYBACK_READY, 'ui-title-update', function () {
				var videoTitle = player.getTitle(),
					videoTime = ooyalaVideoController.getFormattedDuration(player.getDuration());

				$videoContainer.find('.video-title').text(videoTitle);
				$videoContainer.find('.video-time').text(videoTime);
			});

			player.mb.subscribe(window.OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'featured-video', function (eventName, time, totalTime) {
				var secondsPlayed = Math.floor(time),
					percentage = Math.round(time / totalTime * 100);

				if (secondsPlayed % 5 === 0 && secondsPlayed !== playTime) {
					playTime = secondsPlayed;
					track({
						action: tracker.ACTIONS.VIEW,
						label: 'featured-video-played-seconds-' + playTime
					});
				}

				if (percentage % 10 === 0 && percentage !== percentagePlayTime) {
					percentagePlayTime = percentage;
					track({
						action: tracker.ACTIONS.VIEW,
						label: 'featured-video-played-percentage-' + percentagePlayTime
					});
				}

				if (secondsPlayed >= 5 && !videoFeedbackBox && player.getState() === window.OO.STATE.PLAYING) {
					videoFeedbackBox = new VideoFeedbackBox();
					videoFeedbackBox.init();
				}
			});

			track({
				action: tracker.ACTIONS.IMPRESSION,
				label: 'featured-video'
			});
		});

		$closeBtn.click(closeButtonClicked);

		onScroll.bind(toggleCollapse);

		initAttributionTracking();
	});

});
