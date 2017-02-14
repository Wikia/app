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
			collapsingDisabled = false;

		function initVideo(onCreate) {
			var ooyalaJsFile = window.wgArticleVideoData.jsUrl;
			var ooyalaVideoId = window.wgArticleVideoData.videoId;

			ooyalaVideoController = new OoyalaVideo(ooyalaVideoElementId, ooyalaJsFile, ooyalaVideoId, onCreate);
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
				$videoContainer.on('transitionend', function () {
					ooyalaVideoController.sizeChanged();
					ooyalaVideoController.showControls();
				});
			} else {
				ooyalaVideoController.sizeChanged();
				ooyalaVideoController.showControls();
			}
		}

		function toggleCollpase() {
			if (!collapsingDisabled || ooyalaVideoController.player.getState() === OO.STATE.PLAYING || videoCollapsed) {
				var scrollTop = $(window).scrollTop(),
					videoHeight = $video.outerHeight(),
					videoWidth = $video.outerWidth(),
					videoOffset = $video.offset(),
					viewportWidth = $(window).width(),
					viewportHeight = $(window).height(),
					scrollOffset = 100,
					collapseOffset = videoOffset.top + videoHeight - scrollOffset;

				if (scrollTop > collapseOffset && !videoCollapsed) {
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
			ooyalaVideoController.player.play();
		}

		initVideo(function () {
			$video.addClass('ready-to-play');
			$video.one('click', showAndPlayVideo);
		});

		$closeBtn.click(closeButtonClicked);

		onScroll.bind(toggleCollpase);
	});
});
