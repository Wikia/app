/*global define*/
define('ext.wikia.adEngine.video.player.uiTemplate', [], function () {
	'use strict';

	var autoPlayLayout = [
			'progressBar',
			'pauseOverlay',
			'volumeControl',
			'toggleAnimation',
			'replayOverlay'
		],
		defaultLayout = [
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
			'toggleVideo',
			'replayOverlay'
		];

	return {
		autoPlayLayout: autoPlayLayout,
		defaultLayout: defaultLayout,
		splitLayout: splitLayout
	};
});
