require(['wikia.window', 'wikia.tracker', 'wikia.articleVideo.jwPlayerOnScroll'], function (window, tracker, jwPlayerOnScroll) {
	var featureVideoPlayerInstance = window.featureVideoPlayerInstance,
		$featuredVideo = $('.featured-video'),
		$playerContainer = $('.featured-video__player-container');

	jwPlayerOnScroll(featureVideoPlayerInstance, $featuredVideo, $playerContainer);
});