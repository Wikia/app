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
		var isTouchDevice = ('ontouchstart' in win || 'onmsgesturechange' in win),
			onMouseEnter = function () {
				video.setVolume(1);
			},
			onMouseLeave = function () {
				video.setVolume(0);
			};

		if (isTouchDevice) {
			return;
		}

		video.addEventListener('loaded', function () {
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