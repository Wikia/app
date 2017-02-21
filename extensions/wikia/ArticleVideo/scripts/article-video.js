require(['wikia.window', 'wikia.onScroll', 'wikia.tracker', 'ooyalaVideo'], function (window, onScroll, tracker, OoyalaVideo) {

	$(function () {
		var $video = $('#article-video'),
			$videoContainer = $video.find('.video-container'),
			$videoThumbnail = $videoContainer.find('.video-thumbnail'),
			$closeBtn = $videoContainer.find('.close'),
			$videoPlayBtn = $videoContainer.find('.video-play-button'),
			ooyalaVideoController,
			ooyalaVideoElementId = 'ooyala-article-video',
			$ooyalaVideo = $('#' + ooyalaVideoElementId),
			videoCollapsed = false,
			collapsingDisabled = false,
			transitionEndEventName = getTransitionEndEventName(),
			track = tracker.buildTrackingFunction({
				category: 'article-video',
				trackingMethod: 'analytics'
			});

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

		function initVideo(onCreate) {
			var ooyalaVideoId = window.wgArticleVideoData.videoId;

			ooyalaVideoController = new OoyalaVideo(ooyalaVideoElementId, ooyalaVideoId, onCreate);
		}

		function collapseVideo(videoOffset, videoHeight) {
			var videoWidth = $video.outerWidth(),
				viewportWidth = $(window).width(),
				viewportHeight = $(window).height();

			collapsingDisabled = false;
			videoCollapsed = true;
			$video.addClass('collapsed-ready');
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
			$ooyalaVideo.css('height', '');
			$video.removeClass('collapsed collapsed-ready');
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

		function updatePlayerControls(waitForTransition) {
			ooyalaVideoController.hideControls();
			if (waitForTransition && transitionEndEventName) {
				$videoContainer.on(transitionEndEventName, function () {
					ooyalaVideoController.sizeChanged();
					ooyalaVideoController.showControls();
				});
			} else {
				ooyalaVideoController.sizeChanged();
				ooyalaVideoController.showControls();
			}
		}

		function isVideoPlaying() {
			if (ooyalaVideoController && ooyalaVideoController.player) {
				return ooyalaVideoController.player.getState() === OO.STATE.PLAYING;
			}
			return false;
		}

		function isVideoPausedOrReady() {
			if (ooyalaVideoController && ooyalaVideoController.player) {
				return ooyalaVideoController.player.getState() === OO.STATE.PAUSED || ooyalaVideoController.player.getState() === OO.STATE.READY;
			}
			return false;
		}

		function isVideoInFullScreenMode() {
			if (ooyalaVideoController && ooyalaVideoController.player) {
				return ooyalaVideoController.player.getFullscreen();
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
			$ooyalaVideo.show();
			$video.addClass('played');
			ooyalaVideoController.sizeChanged(); // we have to trigger 'size changed' event to have controls in right size
			ooyalaVideoController.player.play();
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
				ooyalaVideoController.player.play();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-collapsed-play'
				});
			} else if (isVideoPlaying()) {
				ooyalaVideoController.player.pause();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'featured-video-collapsed-pause'
				});
			}
		}

		initVideo(function (player) {
			$video.addClass('ready-to-play');
			$video.one('click', showAndPlayVideo);

			player.mb.subscribe(OO.EVENTS.PLAY, 'featured-video', function () {
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
