require(['wikia.window', 'wikia.onScroll', 'wikia.tracker', 'ooyala-player'], function (window, onScroll, tracker, OoyalaPlayer) {

	$(function () {
		var $video = $('#article-video'),
			$relatedVideo = $('#article-related-video'),
			$videoContainer = $video.find('.video-container'),
			$videoThumbnail = $videoContainer.find('.video-thumbnail'),
			$closeBtn = $videoContainer.find('.close'),
			$videoPlayBtn = $videoContainer.find('.video-play-button'),
			ooyalaVideoController,
			ooyalaVideoElementId = 'ooyala-article-video',
			$ooyalaVideo = $('#' + ooyalaVideoElementId),
			videoCollapsed = false,
			collapsingDisabled = false,
			track = tracker.buildTrackingFunction({
				category: 'article-video',
				trackingMethod: 'analytics'
			}),
			collapsedVideoSize = {
				width: 225,
				height: 127
			};

		function initVideo(ooyalaContainerId, videoId, onCreate) {
			var playerParams = window.wgArticleVideoData.playerParams;

			ooyalaVideoController = OoyalaPlayer.initHTMl5Players(ooyalaContainerId, playerParams, videoId, onCreate);
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

		function updateOoyalaSize() {
			window.dispatchEvent(new Event('resize'));
			// wait for player resize - there is 150ms debounce on resize event in ooyala html5-skin
			setTimeout(function () {
				ooyalaVideoController.showControls();
			}, 150);
		}

		function updatePlayerControls(waitForTransition) {
			ooyalaVideoController.hideControls();
			if(!waitForTransition) {
				updateOoyalaSize();
			}
			// otherwise wait for SIZE_CHANGED event and then execute updateOoyalaSize function
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
				return ooyalaVideoController.player.isFullscreen();
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

		function arrangeRelatedVideo() {
			var $articleContent = $('#mw-content-text');
			
			$relatedVideo = $relatedVideo.detach();
			$articleContent.children('h2').eq(1).before( $relatedVideo );
			$relatedVideo.show();
		}
		
		initVideo('ooyala-article-video', window.wgArticleVideoData.videoId, function (player) {
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

			player.mb.subscribe( OO.EVENTS.SIZE_CHANGED, "asd", function(eventName, width, height ){
				if(width === collapsedVideoSize.width && height === collapsedVideoSize.height) {
					updateOoyalaSize();
				}
			});

			track({
				action: tracker.ACTIONS.IMPRESSION,
				label: 'featured-video'
			});
		});
		
		initVideo('ooyala-article-related-video', window.wgArticleRelatedVideoData.videoId, function (player) {
			arrangeRelatedVideo();
			
			// $relatedVideo.addClass('ready-to-play');
			// $relatedVideo.one('click', showAndPlayVideo);

			// player.mb.subscribe(OO.EVENTS.PLAY, 'related-video', function () {
			// 	track({
			// 		action: tracker.ACTIONS.CLICK,
			// 		label: 'related-video-play'
			// 	});
			// });
			//
			// player.mb.subscribe(OO.EVENTS.PLAYED, 'related-video', function () {
			// 	track({
			// 		action: tracker.ACTIONS.CLICK,
			// 		label: 'related-video-played'
			// 	});
			// });
			//
			// player.mb.subscribe(OO.EVENTS.PAUSED, 'related-video', function () {
			// 	track({
			// 		action: tracker.ACTIONS.CLICK,
			// 		label: 'related-video-paused'
			// 	});
			// });
			//
			// track({
			// 	action: tracker.ACTIONS.IMPRESSION,
			// 	label: 'related-video'
			// });
		});

		$closeBtn.click(closeButtonClicked);

		$videoPlayBtn.click(playPauseVideo);

		onScroll.bind(toggleCollapse);
	});
	
});
