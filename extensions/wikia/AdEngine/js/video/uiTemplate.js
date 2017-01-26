/*global define*/
define('ext.wikia.adEngine.video.player.uiTemplate', [], function () {
	'use strict';

	var splitLayout = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'closeButton',
			'toggleVideo',
			'replayOverlay'
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
		splitLayout: splitLayout
	};
});
