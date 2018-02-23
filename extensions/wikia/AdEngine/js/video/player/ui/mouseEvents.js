/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.mouseEvents', [
	'wikia.window'
], function (win) {
	'use strict';

	function muteVideo(video) {
		setTimeout(function () {
			video.setVolume(0);
		});
	}

	function add(video, params) {
		var isTouchDevice = 'ontouchstart' in win || 'onmsgesturechange' in win,
			onMouseEnter = function () {
				video.setVolume(1, true);
			},
			onMouseLeave = function () {
				video.setVolume(0, true);
			};

		video.addEventListener('loaded', function () {
			muteVideo(video);
		});
		video.addEventListener('start', function () {
			muteVideo(video);
		});

		if (!isTouchDevice) {
			video.addEventListener('loaded', function () {
				params.container.addEventListener('mouseenter', onMouseEnter);
				params.container.addEventListener('mouseleave', onMouseLeave);
				video.addEventListener('wikiaVolumeChangeClicked', function () {
					params.container.removeEventListener('mouseenter', onMouseEnter);
					params.container.removeEventListener('mouseleave', onMouseLeave);
				});
			});
		}
	}

	return {
		add: add
	};
});
