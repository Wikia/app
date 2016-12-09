/*global define*/
define('ext.wikia.adEngine.video.player.ui.pauseOverlayFactory', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.pauseOverlayFactory';

	function create(video) {
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

		return overlay;
	}

	return {
		create: create
	};
});
