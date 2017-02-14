require(['wikia.window', 'wikia.onScroll', 'ooyalaVideo'], function (window, onScroll, OoyalaVideo) {
	$(function () {
		var $video = $('#article-video'),
			$videoContainer = $video.find('.video-container'),
			$videoThumbnail = $videoContainer.find('.video-thumbnail'),
			$closeBtn = $videoContainer.find('.close'),
			ooyalaVideo,
			ooyalaVideoElementId = 'ooyala-article-video',
			$ooyalaVideo = $('#' + ooyalaVideoElementId),
			videoCollapsed = false,
			collapsingDisabled = false;

		function initVideo(onCreate) {
			var ooyalaJsFile = window.wgArticleVideoData.jsUrl;
			var ooyalaVideoId = window.wgArticleVideoData.videoId;

			ooyalaVideo = new OoyalaVideo(ooyalaVideoElementId, ooyalaJsFile, ooyalaVideoId, onCreate);
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
			if (ooyalaVideo) {
				updatePlayerControls(false);
			}

		}

		function closeButtonClicked(event) {
			event.stopPropagation();
			if (ooyalaVideo && ooyalaVideo.player) {
				ooyalaVideo.player.pause();
			}
			uncollapseVideo();
			collapsingDisabled = true;
		}

		function updatePlayerControls(waitForTransition) {
			ooyalaVideo.hideControls();
			if (waitForTransition) {
				$videoContainer.on('transitionend', function () {
					ooyalaVideo.sizeChanged();
					ooyalaVideo.showControls();
				});
			} else {
				ooyalaVideo.sizeChanged();
				ooyalaVideo.showControls();
			}
		}

		function toggleCollpase() {
			if (!collapsingDisabled || ooyalaVideo.player.getState() === OO.STATE.PLAYING || videoCollapsed) {
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
					if (ooyalaVideo) {
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
			ooyalaVideo.player.play();
		}

		initVideo(function () {
			$video.addClass('ready-to-play');
			$video.one('click', showAndPlayVideo);
		});

		$closeBtn.click(closeButtonClicked);

		onScroll.bind(toggleCollpase);
	});
});
