/*global define*/
define('ext.wikia.adEngine.video.player.ui.replayOverlay', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.replayOverlay',
		replayOverlayClass = 'replay-overlay';

	function add(video, params) {
		var overlay = doc.createElement('div'),
			overlayPercentWidth = 0;

		if (video.container.classList.contains('video-player-right')) {
			overlay.style.right = 0;
		}

		overlay.classList.add(replayOverlayClass);
		overlay.addEventListener('click', function () {
			video.play();
			log(['replay', log.levels.debug, logGroup]);
			// make overlay invisible
			overlay.style.width = '';
		});

		video.addEventListener('wikiaAdCompleted', function() {
			if (!overlayPercentWidth) {
				overlayPercentWidth = getOverlayWidth(params);
			}

			// make overlay visible after ad finishes
			overlay.style.width = overlayPercentWidth;
		});

		video.container.parentElement.insertBefore(overlay, video.container);
	}

	/**
	 * Basing on video width and total ad width compute width (in %)
	 * of overlay to make it responsive.
	 *
	 * offsetWidth won't work in case video container is hidden.
	 * @param params
	 * @return string in form '55%'
	 */
	function getOverlayWidth(params) {
		var adWidth = params.container.offsetWidth,
			videoWidth = params.hideWhenPlaying.offsetWidth;

		return 100 * videoWidth / adWidth + '%';
	}

	return {
		add: add
	};
});
