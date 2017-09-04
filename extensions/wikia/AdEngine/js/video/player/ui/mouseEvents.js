/*global define, setTimeout*/
define('ext.wikia.adEngine.video.player.ui.mouseEvents', [], function () {
	'use strict';

	function add(video, params) {
		video.addEventListener('loaded', function () {
			var adsManager = video.ima.getAdsManager();

			setTimeout(function () {
				adsManager.setVolume(0);
			});

			// TODO user's click on mute/unmute button
			params.container.addEventListener('mouseenter', function () {
				adsManager.setVolume(1);
			});
			params.container.addEventListener('mouseleave', function () {
				adsManager.setVolume(0);
			});
		});

		video.addEventListener('start', function () {
			setTimeout(function () {
				video.ima.getAdsManager().setVolume(0);
			});
		});
	}

	return {
		add: add
	};
});