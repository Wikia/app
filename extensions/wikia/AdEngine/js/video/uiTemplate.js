/*global define*/
define('ext.wikia.adEngine.video.player.uiTemplate', [], function () {
	'use strict';

	var autoPlay = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'toggleAnimation'
		],
		defaultTemplate = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'closeButton',
			'toggleAnimation'
		],
		splitLayout = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'toggleVideo'
		];

	return {
		autoPlay: autoPlay,
		defaultTemplate: defaultTemplate,
		splitLayout: splitLayout
	};
});
