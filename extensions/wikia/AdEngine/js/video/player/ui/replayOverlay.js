/*global define*/
define('ext.wikia.adEngine.video.player.ui.replayOverlay', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.replayOverlay',
		replayOverlayClass = 'replay-overlay';

	function add(video) {
		var overlay = doc.createElement('div');

		overlay.classList.add(replayOverlayClass);
		overlay.addEventListener('click', function () {
			video.play();
			log(['resume', log.levels.debug, logGroup]);
			// make overlay invisible
			overlay.style.width = '';
		});

		video.addEventListener('wikiaAdCompleted', function() {
			// make overlay visible after ad finishes
			overlay.style.width = getOverlayWidth(video);
		});

		video.container.parentElement.insertBefore(overlay, video.container);
	}

	/**
	 * Basing on width set on video container and screen width compute width (in %)
	 * of overlay to make it responsive.
	 *
	 * offsetWidth won't work in case video container is hidden.
	 * @param video
	 * @return string in form '55%'
	 */
	function getOverlayWidth(video) {
		var windowWidth = Math.max(doc.documentElement.clientWidth, window.innerWidth || 0),
			videoContainerWidthString = video.container.style.width,
			videoContainerWidth = parseInt(videoContainerWidthString.substr(0, videoContainerWidthString.length -2));

		return 100 * videoContainerWidth / windowWidth + '%';
	}

	return {
		add: add
	};
});
