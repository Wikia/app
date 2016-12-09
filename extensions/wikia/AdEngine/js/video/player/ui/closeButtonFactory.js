/*global define*/
define('ext.wikia.adEngine.video.player.ui.closeButtonFactory', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.video.player.ui.closeButtonFactory';

	function create(video) {
		var closeButton = doc.createElement('div');
		closeButton.classList.add('close-ad');

		closeButton.addEventListener('click', function () {
			video.stop();
			log(['stop', log.levels.debug, logGroup]);
		});

		return closeButton;
	}

	return {
		create: create
	};
});
