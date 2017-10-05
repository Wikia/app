define('wikia.articleVideo.featuredVideo.jwplayer.videoFeedback', ['wikia.articleVideo.videoFeedbackBox'], function (VideoFeedbackBox) {

	return function (playerInstance) {

		var videoFeedbackBox;

		function videoFeedbackInit(event) {
			if (event.position >= 2 && !videoFeedbackBox && playerInstance.getState() === 'playing') {
				videoFeedbackBox = new VideoFeedbackBox('.featured-video .video-feedback');
				videoFeedbackBox.init();
				playerInstance.off('time', videoFeedbackInit)
			}
		}

		playerInstance.on('time', videoFeedbackInit);

		playerInstance.on('play', function () {
			if (videoFeedbackBox) {
				videoFeedbackBox.show();
			}
		});

		playerInstance.on('pause', function () {
			if (videoFeedbackBox) {
				videoFeedbackBox.hide();
			}
		});
	}
});
