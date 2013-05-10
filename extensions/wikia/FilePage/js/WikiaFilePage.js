$(function() {

var WikiaFilePage = {
	/*
	 * Use VideoBootstrap to create a video instance
	 */
	initVideo: function() {
		if(window.playerParams) {
			require(['wikia.videoBootstrap'], function (VideoBootstrap) {

				var element = $('#file'),
					videoInstance = new VideoBootstrap(element[0], window.playerParams, 'filePage');

				$(window).on('lightboxOpened', function() {
					videoInstance.reload(wgTitle, 670, false);
				});

			});
		}
	}
}

WikiaFilePage.initVideo();

});