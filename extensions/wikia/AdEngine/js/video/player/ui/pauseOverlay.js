/*global define*/
define('ext.wikia.adEngine.video.player.ui.pauseOverlay', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.pauseOverlay';

	function add(video) {
		var overlay = doc.createElement('div');

		overlay.classList.add('pause-overlay');

		overlay.addEventListener('click', function () {
			if (video.isPaused()) {
				video.resume();
				log(['resume', log.levels.debug, logGroup]);
			} else {
				video.pause();
				log(['pause', log.levels.debug, logGroup]);
			}
		});

		video.container.appendChild(overlay);
	}

	return {
		add: add
	};
});
