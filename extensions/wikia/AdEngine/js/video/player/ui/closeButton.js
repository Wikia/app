/*global define*/
define('ext.wikia.adEngine.video.player.ui.closeButton', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.closeButton';

	function add(video) {
		var closeButton = doc.createElement('div');
		closeButton.classList.add('close-ad');

		closeButton.addEventListener('click', function (event) {
			video.stop();
			event.preventDefault();
			log(['stop', log.levels.debug, logGroup]);
		});

		video.container.appendChild(closeButton);
	}

	return {
		add: add
	};
});
