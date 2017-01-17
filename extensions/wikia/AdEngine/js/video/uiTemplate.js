/*global define*/
define('ext.wikia.adEngine.video.player.uiTemplate', [], function () {
	'use strict';

	var autoPlay = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'closeButton',
			'toggle'
		],
		defaultTemplate = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'closeButton',
			'toggleAnimation'
		];

	return {
		default: defaultTemplate,
		autoPlay: autoPlay
	};
});
