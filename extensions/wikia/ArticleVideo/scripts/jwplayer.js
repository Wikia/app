require(['wikia.window', 'wikia.tracker', 'wikia.articleVideo.jwPlayerOnScroll', 'wikia.articleVideo.jwPlayerVideoFeedback', 'jwplayer.instance'], function (window, tracker, jwPlayerOnScroll, jwPlayerVideoFeedback, playerInstance) {
	var $featuredVideo = $('.featured-video'),
		$playerContainer = $('.featured-video__player-container');

	jwPlayerOnScroll(playerInstance, $featuredVideo, $playerContainer);
	jwPlayerVideoFeedback(playerInstance);
});