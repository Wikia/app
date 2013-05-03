$(function() {

var WikiaFilePage = {
	/*
	 * Use VideoBootstrap to create a video instance
	 */
	initVideo: function() {
		if(window.playerParams) {
			require(['wikia.videoBootstrap'], function (videoBootstrap) {

				var element = $('#file'),
					videoInstance = new videoBootstrap(element[0], window.playerParams);

				$(window).on('lightboxOpened', function() {
					videoInstance.reload(wgTitle, 670, false);
				});

			});
		}
	}
}

WikiaFilePage.initVideo();

});