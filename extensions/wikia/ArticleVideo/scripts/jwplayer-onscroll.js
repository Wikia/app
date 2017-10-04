define('wikia.articleVideo.jwPlayerOnScroll', ['wikia.onScroll'], function (onScroll) {
	return function (featureVideoPlayerInstance, $featuredVideo, $playerContainer) {
		var videoCollapsed = false,
			collapsingDisabled = false;

		// TODO move to separated module
		function whichTransitionEvent(){
			var t;
			var el = document.createElement('fakeelement');
			var transitions = {
				'transition':'transitionend',
				'OTransition':'oTransitionEnd',
				'MozTransition':'transitionend',
				'WebkitTransition':'webkitTransitionEnd'
			};

			for(t in transitions){
				if( el.style[t] !== undefined ){
					return transitions[t];
				}
			}
		}

		function isVideoInFullScreenMode() {
			return featureVideoPlayerInstance.getFullscreen();
		}

		function collapseVideo(videoOffset, videoHeight) {
			var videoWidth = $playerContainer.outerWidth(),
				viewportWidth = $(window).width(),
				viewportHeight = $(window).height();

			collapsingDisabled = false;
			videoCollapsed = true;
			$featuredVideo.addClass('is-collapsed-ready');
			$playerContainer.css({
				'bottom': viewportHeight - videoOffset.top - videoHeight + $(window).scrollTop(),
				'right': viewportWidth - videoOffset.left - videoWidth,
				'width': videoWidth
			});
			setTimeout(function () {
				if (videoCollapsed) { // we need to be sure video has not been uncollapsed yet
					$featuredVideo.addClass('is-collapsed');
				}
			}, 0);
		}

		function uncollapseVideo() {
			videoCollapsed = false;
			$playerContainer.css({
				'position': '',
				'bottom': '',
				'right': '',
				'top': '',
				'left': '',
				'width': ''
			});
			$featuredVideo.removeClass('is-collapsed is-collapsed-ready');
			featureVideoPlayerInstance.resize();
		}

		function toggleCollapse() {
			// That's for Safari because it triggers scroll event (it scrolls to the top)
			// when video is switched to full screen mode.
			if (isVideoInFullScreenMode()) {
				return;
			}
			if (!collapsingDisabled || videoCollapsed) {
				var scrollTop = $(window).scrollTop(),
					videoHeight = $featuredVideo.outerHeight(),
					videoOffset = $featuredVideo.offset(),
					scrollOffset = 100,
					collapseOffset = videoOffset.top + videoHeight - scrollOffset;

				if (scrollTop > collapseOffset && !videoCollapsed) {
					collapseVideo(videoOffset, videoHeight);
				} else if (scrollTop <= collapseOffset && videoCollapsed) {
					uncollapseVideo();
				}
			}
		}

		var transitionEvent = whichTransitionEvent();
		transitionEvent && $playerContainer[0].addEventListener(transitionEvent, function (event) {
			if (event.propertyName === 'width') {
				featureVideoPlayerInstance.resize();
			}
		});

		onScroll.bind(toggleCollapse);
	}
});
