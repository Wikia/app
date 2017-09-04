/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.mouseEvents', [], function () {
	'use strict';

	function add(video, params) {
		var userHasChangedVolumeManually = false;

		video.addEventListener('loaded', function () {
			setTimeout(function () {
				video.setVolume(0);
			});

			video.addEventListener('wikiaVolumeChangeClicked', function () {
				userHasChangedVolumeManually = true;
			});
			params.container.addEventListener('mouseenter', function () {
				if (!userHasChangedVolumeManually) {
					video.setVolume(1);
				}
			});
			params.container.addEventListener('mouseleave', function () {
				if (!userHasChangedVolumeManually) {
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