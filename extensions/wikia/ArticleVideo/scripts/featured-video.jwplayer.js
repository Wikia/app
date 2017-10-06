require([
	'wikia.window',
	'wikia.tracker',
	'wikia.articleVideo.featuredVideo.jwplayer.onScroll',
	'wikia.articleVideo.featuredVideo.jwplayer.videoFeedback',
	'wikia.articleVideo.featuredVideo.jwplayer.autoplayToggle',
	'wikia.articleVideo.featuredVideo.jwplayer.instance'
], function (window,
             tracker,
             jwPlayerOnScroll,
             jwPlayerVideoFeedback,
             jwPlayerAutoplayToggle,
             playerInstance) {
	var $featuredVideo = $('.featured-video'),
		$playerContainer = $('.featured-video__player-container');

	jwPlayerOnScroll(playerInstance, $featuredVideo, $playerContainer);
	jwPlayerVideoFeedback(playerInstance);
	jwPlayerAutoplayToggle(playerInstance);
});
