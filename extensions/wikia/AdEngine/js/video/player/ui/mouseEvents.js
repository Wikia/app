/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.mouseEvents', [], function () {
	'use strict';

	function muteVideo(video) {
		setTimeout(function () {
			video.setVolume(0);
		});
	}

	function add(video, params) {
		video.addEventListener('loaded', function () {
			var onMouseEnter = function () {
					video.setVolume(1);
				},
				onMouseLeave = function () {
					video.setVolume(0);
				};

			muteVideo(video);
			params.container.addEventListener('mouseenter', onMouseEnter);
			params.container.addEventListener('mouseleave', onMouseLeave);
			video.addEventListener('wikiaVolumeChangeClicked', function () {
				params.container.removeEventListener('mouseenter', onMouseEnter);
				params.container.removeEventListener('mouseleave', onMouseLeave);
			});
		});

		video.addEventListener('start', function () {
			muteVideo(video);
		});
	}

	return {
		add: add
	};
});