define('videoScrollBehaviour', ['wikia.window', 'wikia.loader', 'jquery', 'ooyalaVideo'], function (window, loader, $, OoyalaVideo) {
	'use strict';

	function videoScrollBehaviour(containerId, scrollPosition, youtubeID) {
		var videoCollapsed = false;

		var $videoCollapse = $(containerId + ' .video-collpased');
		$videoCollapse.addClass(scrollPosition);


		var $video = $(containerId + ' .videoo');
		var videoWidth = $video.outerWidth();
		var videoHeight = $video.outerHeight();
		var videoOffset = $video.offset();

		var viewportWidth = $(window).width();
		var viewportHeight = $(window).height();

		var scrollOffset = 100;
		var collapseOffset = videoOffset.top + videoHeight - scrollOffset;

		var ooyalaVideo;


		$video.one('click', function () {
			$videoCollapse.addClass('video-playing');
			// $videoCollapse.append('<iframe src="https://www.youtube.com/embed/' + youtubeID + '?showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
			//
			var ooyalaJsFile = window.wgArticleVideoData.jsParams.jsFile[0];
			var ooyalaVideoId = window.wgArticleVideoData.jsParams.videoId;
			//
			// loadJs(ooyalaJsFile).done(function () {
			// 	window.OO.ready(function () {
			// 		window.OO.Player.create('ooyala-article-video', ooyalaVideoId, {
			// 			autoplay: true,
			// 			width: '100%',
			// 			height: '100%'
			// 		});
			// 	});
			// });
			ooyalaVideo = new OoyalaVideo('ooyala-article-video', ooyalaJsFile, ooyalaVideoId);
		});

		function loadJs(resource) {
			return loader({
				type: loader.JS,
				resources: resource
			}).fail(loadFail);
		}

		// log any errors from failed script loading (VID-976)
		function loadFail(data) {
			var message = data.error + ':';

			$.each(data.resources, function () {
				message += ' ' + this;
			});

			log(message, log.levels.error, 'asd');
		}

		$(window).scroll(function () {
			if ($(window).scrollTop() > collapseOffset && !videoCollapsed) {
				videoCollapsed = true;
				$videoCollapse.addClass('collapsed-ready');
				if(ooyalaVideo) {
					ooyalaVideo.miniControls();
				}
				$videoCollapse.css(getVideoCollpasedReadyStyles());
				setTimeout(function () {
					$videoCollapse.addClass('collapsed');
				}, 0);
			} else if ($(window).scrollTop() <= collapseOffset && videoCollapsed) {
				videoCollapsed = false;
				$videoCollapse.css({
					'position': 'absolute',
					'bottom': 'auto',
					'right': 'auto',
					'top': '0',
					'left': '0',
					'width': videoWidth
				});
				$videoCollapse.removeClass('collapsed collapsed-ready');
				if(ooyalaVideo) {
					ooyalaVideo.fullControls();
				}
			}
		});

		function getVideoCollpasedReadyStyles() {
			switch (scrollPosition) {
				case 'top-right':
					return {
						'position': 'fixed',
						'bottom': 'auto',
						'right': viewportWidth - videoOffset.left - videoWidth,
						'top': videoOffset.top - $(window).scrollTop(),
						'left': 'auto',
						'width': videoWidth
					};
				case 'bottom-left':
					return {
						'position': 'fixed',
						'bottom': viewportHeight - videoOffset.top - videoHeight + $(window).scrollTop(),
						'right': 'auto',
						'top': 'auto',
						'left': videoOffset.left,
						'width': videoWidth
					};
				default:
					return {
						'position': 'fixed',
						'bottom': viewportHeight - videoOffset.top - videoHeight + $(window).scrollTop(),
						'right': viewportWidth - videoOffset.left - videoWidth,
						'top': 'auto',
						'left': 'auto',
						'width': videoWidth
					};
			}
		}
	}

	return videoScrollBehaviour;
});