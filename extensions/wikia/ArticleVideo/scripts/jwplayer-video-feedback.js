define('wikia.articleVideo.jwPlayerVideoFeedback', ['wikia.articleVideo.videoFeedbackBox'], function (VideoFeedbackBox) {

	return function (featureVideoPlayerInstance) {

		var videoFeedbackBox;

		featureVideoPlayerInstance.on('time', function (event) {
			if (event.position >= 5 && !videoFeedbackBox && featureVideoPlayerInstance.getState() === 'playing') {
				videoFeedbackBox = new VideoFeedbackBox('.featured-video .video-feedback');
				videoFeedbackBox.init();
			}
		});

		featureVideoPlayerInstance.on('play', function () {
			if (videoFeedbackBox) {
				videoFeedbackBox.show();
			}
		});

		featureVideoPlayerInstance.on('pause', function () {
			if (videoFeedbackBox) {
				videoFeedbackBox.hide();
			}
		});

	}

});
