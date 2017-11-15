/*global define*/
define('ext.wikia.adEngine.video.player.ui.toggleFullscreen', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.toggleFullscreen';

	function add(video) {
		var toggleFullscreenButton = doc.createElement('div');
		toggleFullscreenButton.classList.add('toggle-fullscreen');

		// TODO: replace with proper image asset in CSS
		toggleFullscreenButton.innerText = 'F';

		toggleFullscreenButton.addEventListener('click', function (event) {
			video.toggleFullscreen();
			event.preventDefault();
			log(['toggleFullscreen', log.levels.debug, logGroup]);
		});

		video.container.appendChild(toggleFullscreenButton);
	}

	return {
		add: add
	};
});
