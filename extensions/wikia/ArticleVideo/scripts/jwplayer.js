require(['wikia.window', 'wikia.tracker', 'wikia.articleVideo.jwPlayerOnScroll', 'wikia.articleVideo.videoFeedbackBox', 'jwplayer.instance'], function (window, tracker, jwPlayerOnScroll, VideoFeedbackBox, playerInstance) {
	var videoFeedbackBox,
		$featuredVideo = $('.featured-video'),
		$playerContainer = $('.featured-video__player-container');

	jwPlayerOnScroll(playerInstance, $featuredVideo, $playerContainer);

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
});