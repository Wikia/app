$(function() {

var WikiaFilePage = {
	/*
	 * Use VideoBootstrap to create a video instance
	 */
	initVideo: function() {
		if(window.playerParams) {
			require(['wikia.videoBootstrap'], function (VideoBootstrap) {

				var element = $('#file'),
					clickSource = 'filePage',
					videoInstance = new VideoBootstrap(element[0], window.playerParams, clickSource);

				$(window).on('lightboxOpened', function() {
					videoInstance.reload(wgTitle, 670, false, clickSource);
				});

			});
		}
	}
}

WikiaFilePage.initVideo();

});