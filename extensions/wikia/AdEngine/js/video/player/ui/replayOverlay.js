/*global define*/
define('ext.wikia.adEngine.video.player.ui.replayOverlay', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.replayOverlay';

	function add(video) {
		var overlay = doc.createElement('div');

		overlay.classList.add('replay-overlay');

		overlay.addEventListener('click', function () {
			video.play();
			log(['resume', log.levels.debug, logGroup]);
			// make overlay invisible
			overlay.style.width = '';
			overlay.style.height = '';
		});

		video.addEventListener('wikiaAdCompleted', function () {
			// make overlay visible after ad finishes
			overlay.style.width = video.container.style.width;
			overlay.style.height = video.container.style.height;
		});

		video.container.parentElement.insertBefore(overlay, video.container);
	}

	return {
		add: add
	};
});
