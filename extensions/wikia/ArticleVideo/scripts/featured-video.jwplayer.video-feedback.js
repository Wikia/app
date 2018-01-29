define('wikia.articleVideo.featuredVideo.jwplayer.videoFeedback', ['wikia.articleVideo.videoFeedbackBox'], function (VideoFeedbackBox) {

	return function (playerInstance) {
		var videoFeedbackBox;

		function videoFeedbackInit(event) {
			if (event.position >= 5 && !videoFeedbackBox && playerInstance.getState() === 'playing') {
				videoFeedbackBox = new VideoFeedbackBox('.featured-video .video-feedback', playerInstance);
				videoFeedbackBox.init();
				playerInstance.off('time', videoFeedbackInit)
			}
		}

		playerInstance.on('play', function () {
			if (videoFeedbackBox) {
				videoFeedbackBox.show();
			} else {
				// playerInstance.on('time', videoFeedbackInit);
			}
		});

		playerInstance.on('pause', function () {
			if (videoFeedbackBox) {
				videoFeedbackBox.hide();
			}
		});

		playerInstance.on('complete', function () {
			if (videoFeedbackBox) {
				videoFeedbackBox.hide();
				videoFeedbackBox = null;
			}
		});
	}
});
