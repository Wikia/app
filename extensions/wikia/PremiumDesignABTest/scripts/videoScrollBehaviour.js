define('videoScrollBehaviour', ['wikia.window', 'jquery'], function (window, $) {
	'use strict';

	function videoScrollBehaviour(containerId, scrollPosition, youtubeID) {
		var videoCollapsed = false;

		var $videoCollapse = $(containerId + ' .video-collpased');
		$videoCollapse.addClass(scrollPosition);


		var $video = $(containerId + ' .video');
		var videoWidth = $video.outerWidth();
		var videoHeight = $video.outerHeight();
		var videoOffset = $video.offset();

		var viewportWidth = $(window).width();
		var viewportHeight = $(window).height();

		var scrollOffset = 100;
		var collapseOffset = videoOffset.top + videoHeight - scrollOffset;


		$video.one('click', function () {
			$videoCollapse.addClass('video-playing');
			$videoCollapse.append('<iframe src="https://www.youtube.com/embed/' + youtubeID + '?showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
		});

		$(window).scroll(function () {
			if ($(window).scrollTop() > collapseOffset && !videoCollapsed) {
				videoCollapsed = true;
				$videoCollapse.addClass('collapsed-ready');
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