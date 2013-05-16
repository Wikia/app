require(['wikia.videoBootstrap', 'jquery', 'wikia.window'], function (VideoBootstrap, jquery, window) {

	'use strict';

	/*
	 * Use VideoBootstrap to create a video instance
	 */
	function initVideo() {
		if(window.playerParams) {
			var filePageVideoWidth = 670,
				element = $('#file'),
				clickSource = 'filePage',
				videoInstance = new VideoBootstrap(element[0], window.playerParams, clickSource);

			$(window).on('lightboxOpened', function() {
				videoInstance.reload(wgTitle, filePageVideoWidth, false, clickSource);
			});
		}
	}

	$(initVideo);

});