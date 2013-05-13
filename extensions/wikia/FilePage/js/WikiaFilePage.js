$(function() {

require(['wikia.videoBootstrap'], function (VideoBootstrap) {

	/*
	 * Use VideoBootstrap to create a video instance
	 */
	if(window.playerParams) {
		var element = $('#file'),
			clickSource = 'filePage',
			videoInstance = new VideoBootstrap(element[0], window.playerParams, clickSource);

		$(window).on('lightboxOpened', function() {
			videoInstance.reload(wgTitle, 670, false, clickSource);
		});
	}

});

});