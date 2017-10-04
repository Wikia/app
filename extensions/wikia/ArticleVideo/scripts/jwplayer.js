require(['wikia.window', 'wikia.tracker', 'wikia.articleVideo.jwPlayerOnScroll', 'wikia.articleVideo.jwPlayerVideoFeedback'], function (window, tracker, jwPlayerOnScroll, jwPlayerVideoFeedback) {
	var featureVideoPlayerInstance = window.featureVideoPlayerInstance,
		$featuredVideo = $('.featured-video'),
		$playerContainer = $('.featured-video__player-container');

	jwPlayerOnScroll(featureVideoPlayerInstance, $featuredVideo, $playerContainer);
	jwPlayerVideoFeedback(featureVideoPlayerInstance);

});