require(['wikia.window', 'wikia.onScroll', 'ooyalaVideo'], function (window, onScroll, OoyalaVideo) {
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
			transitionEndEventName = getTransitionEndEventName();

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
		}

		function updatePlayerControls(waitForTransition) {
			ooyalaVideoController.hideControls();
			if (waitForTransition) {
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
		}

		function isVideoInFullScreenMode() {
			if (ooyalaVideoController && ooyalaVideoController.player) {
				return ooyalaVideoController.player.getFullscreen();
			}
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
				} else if (scrollTop <= collapseOffset && videoCollapsed) {
					uncollapseVideo();
				}
			}
		}

		function showAndPlayVideo() {
			$ooyalaVideo.show();
			$video.addClass('playing');
			ooyalaVideoController.sizeChanged(); // we have to trigger 'size changed' event to have controls in right size
			ooyalaVideoController.player.play();
		}

		initVideo(function () {
			$video.addClass('ready-to-play');
			$video.one('click', showAndPlayVideo);
		});

		$closeBtn.click(closeButtonClicked);

		onScroll.bind(toggleCollapse);
	});
});
