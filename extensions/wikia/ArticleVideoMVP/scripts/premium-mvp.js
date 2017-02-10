require(['wikia.window', 'ooyalaVideo'], function (window, OoyalaVideo) {
	$(function () {
		var $video = $('#premium-mvp-video'),
			$videoContainer = $video.find('.video-container'),
			$closeBtn = $videoContainer.find('.close'),
			ooyalaVideo,
			videoCollapsed = false,
			collapsingDisabled = false,
			videoHeight = $video.outerHeight(),
			videoWidth = $video.outerWidth(),
			videoOffset = $video.offset(),
			viewportWidth = $(window).width(),
			viewportHeight = $(window).height(),
			scrollOffset = 100,
			collapseOffset = videoOffset.top + videoHeight - scrollOffset;

		function initVideo() {
			var ooyalaJsFile = window.wgArticleVideoData.jsUrl;
			var ooyalaVideoId = window.wgArticleVideoData.videoId;

			ooyalaVideo = new OoyalaVideo('ooyala-article-video', ooyalaJsFile, ooyalaVideoId);
		}

		function uncollapseVideo() {
			videoCollapsed = false;
			$videoContainer.css({
				'position': 'static',
				'bottom': 'auto',
				'right': 'auto',
				'top': 'auto',
				'left': 'auto',
				'width': 'auto'
			});
			$video.removeClass('collapsed');
			if (ooyalaVideo) {
				ooyalaVideo.fullControls();
			}

		}

		function closeButtonClicked() {
			if (ooyalaVideo && ooyalaVideo.player) {
				ooyalaVideo.player.pause();
			}
			uncollapseVideo();
			collapsingDisabled = true;
		}

		function toggleCollpase() {
			if (!collapsingDisabled || ooyalaVideo.player.getState() === OO.STATE.PLAYING || videoCollapsed) {
				if ($(window).scrollTop() > collapseOffset && !videoCollapsed) {
					collapsingDisabled = false;
					videoCollapsed = true;
					if (ooyalaVideo) {
						ooyalaVideo.miniControls();
					}
					$videoContainer.css({
						'position': 'fixed',
						'bottom': viewportHeight - videoOffset.top - videoHeight + $(window).scrollTop(),
						'right': viewportWidth - videoOffset.left - videoWidth,
						'top': 'auto',
						'left': 'auto',
						'width': videoWidth
					});
					setTimeout(function () {
						$video.addClass('collapsed');
					}, 0);
				} else if ($(window).scrollTop() <= collapseOffset && videoCollapsed) {
					uncollapseVideo();
				}
			}
		}

		$video.one('click', initVideo);

		$closeBtn.click(closeButtonClicked);

		$(window).scroll(toggleCollpase);

	});
});