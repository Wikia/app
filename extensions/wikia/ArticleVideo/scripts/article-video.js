require(['wikia.window', 'wikia.onScroll', 'wikia.tracker', 'ooyalaVideo', 'youtubeVideo'], function (window, onScroll, tracker, OoyalaVideo, YouTubeVideo) {

	$(function () {
		var $video = $('#article-video'),
			$videoContainer = $video.find('.video-container'),
			$videoThumbnail = $videoContainer.find('.video-thumbnail'),
			$closeBtn = $videoContainer.find('.close'),
			$videoPlayBtn = $videoContainer.find('.video-play-button'),
			videoController,
			featuredVideoElementId = 'featured-video-player',
			$featuredVideo = $('#' + featuredVideoElementId),
			videoCollapsed = false,
			collapsingDisabled = false,
			transitionEndEventName = getTransitionEndEventName(),
			track = tracker.buildTrackingFunction({
				category: 'article-video',
				trackingMethod: 'analytics'
			}),
			playMode = getPlayMode();


		function getTransitionEndEventName() {
			var el = document.createElement('div'),
				transitions = {
					'transition': 'transitionend',
					'OTransition': 'oTransitionEnd',
					'MozTransition': 'transitionend',
					'WebkitTransition': 'webkitTransitionEnd'
				};

			for (var t in transitions) {
				if (el.style[t] !== undefined) {
					return transitions[t];
				}
			}

			return null;
		}

		function getPlayMode() {
			var experimentGroup = window.Wikia.AbTest.getGroup('FEATURED_VIDEO_AUTOPLAY');
			if(experimentGroup) {
				return experimentGroup;
			}
			return 'CLICK';
		}

		function initVideo(onCreate) {
			var videoId = window.wgArticleVideoData.videoId;
			var videoProvider = window.wgArticleVideoData.videoProvider;

			if(videoProvider === 'youtube') {
				YouTubeVideo.create(featuredVideoElementId, videoId, onCreate);
			} else {
				OoyalaVideo.create(featuredVideoElementId, videoId, onCreate);
			}
		}

		function collapseVideo(videoOffset, videoHeight) {
			var videoWidth = $video.outerWidth(),
				viewportWidth = $(window).width(),
				viewportHeight = $(window).height();

			collapsingDisabled = false;
			videoCollapsed = true;
			$video.addClass('collapsed-ready');
			if (videoController && videoController.videoProvider === 'ooyala') {
				updatePlayerControls(true);
			}
			$videoContainer.css({
				'bottom': viewportHeight - videoOffset.top - videoHeight + $(window).scrollTop(),
				'right': viewportWidth - videoOffset.left - videoWidth,
				'width': videoWidth
			});
			$videoThumbnail.css('height', videoHeight);
			$featuredVideo.css('height', videoHeight);
			setTimeout(function () {
				if (videoCollapsed) { // we need to be sure video has not been uncollapsed yet
					$video.addClass('collapsed');
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
			$featuredVideo.css('height', '');
			$video.removeClass('collapsed collapsed-ready');
			if (videoController && videoController.videoProvider === 'ooyala') {
				updatePlayerControls(false);
			}

		}

		function closeButtonClicked(event) {
			event.stopPropagation();
			if (videoController) {
				videoController.pause();
			}
			uncollapseVideo();
			collapsingDisabled = true;
			track({
				action: tracker.ACTIONS.CLOSE,
				label: 'featured-video-collapsed'
			});
		}

		function updatePlayerControls(waitForTransition) {
			videoController.hideControls();
			if (waitForTransition && transitionEndEventName) {
				$videoContainer.on(transitionEndEventName, function () {
					videoController.sizeChanged();
					videoController.showControls();
				});
			} else {
				videoController.sizeChanged();
				videoController.showControls();
			}
		}

		function isVideoPlaying() {
			return videoController.isPlaying();
		}

		function isVideoPausedOrReady() {
			return videoController.isReadyToPlay();
		}

		function isVideoInFullScreenMode() {
			if (videoController) {
				return videoController.inFullscreen();
			}
			return false;
		}

		function toggleCollapse() {
			// That's for Safari because it triggers scroll event (it scrolls to the top)
			// when video is switched to full screen mode.
			if (isVideoInFullScreenMode()) {
				return;
			}
			if (!collapsingDisabled || isVideoPlaying() || videoCollapsed) {
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

		function showAndPlayVideo() {
			$('#' + featuredVideoElementId).show(); // fixme
			videoController.play();
			$video.addClass('played');
			if(videoController.videoProvider === 'ooyala') {
				videoController.sizeChanged(); // we have to trigger 'size changed' event to have controls in right size
			}
			track({
				action: tracker.ACTIONS.PLAY_VIDEO,
				label: 'featured-video'
			});
		}

		function playPauseVideo() {
			if (!$video.hasClass('played')) {
				return;
			}
			if (isVideoPausedOrReady()) {
				videoController.play();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-collapsed-play'
				});
			} else if (isVideoPlaying()) {
				videoController.pause();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-collapsed-pause'
				});
			}
		}

		initVideo(function (controller) {
			videoController = controller;
			$video.addClass('ready-to-play');
			switch(playMode) {
				case 'CLICK':
					$video.one('click', showAndPlayVideo);
					break;
				case 'AUTOPLAY':
					showAndPlayVideo();
					break;
				case 'COUNTDOWN':
					// TODO
					showAndPlayVideo();
					break;
			}

			videoController.onPlay(function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-play'
				});
			});

			videoController.onPlayed(function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-played'
				});
			});

			videoController.onPause(function () {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-paused'
				});
			});

			track({
				action: tracker.ACTIONS.IMPRESSION,
				label: 'featured-video'
			});
		});

		$closeBtn.click(closeButtonClicked);

		$videoPlayBtn.click(playPauseVideo);

		onScroll.bind(toggleCollapse);

	});

});
