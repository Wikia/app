require(['wikia.window', 'wikia.tracker', 'wikia.articleVideo.jwPlayerOnScroll', 'wikia.articleVideo.videoFeedbackBox'], function (window, tracker, jwPlayerOnScroll, VideoFeedbackBox) {
	var featureVideoPlayerInstance = window.featureVideoPlayerInstance,
		videoFeedbackBox,
		$featuredVideo = $('.featured-video'),
		$playerContainer = $('.featured-video__player-container');

	jwPlayerOnScroll(featureVideoPlayerInstance, $featuredVideo, $playerContainer);
	featureVideoPlayerInstance.on('time', function (event) {
		if (event.position >= 2 && !videoFeedbackBox && featureVideoPlayerInstance.getState() === 'playing') {
			videoFeedbackBox = new VideoFeedbackBox('.featured-video .video-feedback');
			videoFeedbackBox.init();
		}
	});

	featureVideoPlayerInstance.on('play', function () {
		if(videoFeedbackBox) {
			videoFeedbackBox.show();
		}
	});

	featureVideoPlayerInstance.on('pause', function () {
		if(videoFeedbackBox) {
			videoFeedbackBox.hide();
		}
	});
});