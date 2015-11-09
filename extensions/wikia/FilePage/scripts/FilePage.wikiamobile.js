/**
 * Any mobile-specific js for file page goes here.
 * @author Liz Lee
 */

(function () {
	'use strict';

	// Play video
	var VideoBootstrap = require('wikia.videoBootstrap'),
		window = require('wikia.window'),
		filePageContainer = document.getElementById('file');

	if (filePageContainer && window.playerParams) {
		new VideoBootstrap(filePageContainer, window.playerParams, 'filePage');
	}
})();
