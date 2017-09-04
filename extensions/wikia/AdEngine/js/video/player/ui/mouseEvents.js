/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.mouseEvents', [], function () {
	'use strict';

	function add(video, params) {
		var isVolumeChangedManually = false;

		video.addEventListener('loaded', function () {
			setTimeout(function () {
				video.setVolume(0);
			});

			video.addEventListener('wikiaVolumeChangeClicked', function () {
				isVolumeChangedManually = true;
			});
			params.container.addEventListener('mouseenter', function () {
				if (!isVolumeChangedManually) {
					video.setVolume(1);
				}
			});
			params.container.addEventListener('mouseleave', function () {
				if (!isVolumeChangedManually) {
					video.setVolume(0);
				}
			});
		});

		video.addEventListener('start', function () {
			setTimeout(function () {
				video.setVolume(0);
			});
		});
	}

	return {
		add: add
	};
});