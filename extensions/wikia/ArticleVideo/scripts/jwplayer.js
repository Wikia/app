require([
	'wikia.window',
	'wikia.tracker',
	'wikia.articleVideo.jwPlayerOnScroll',
	'wikia.articleVideo.jwPlayerVideoFeedback',
	'wikia.articleVideo.jwPlayerAutoplayToggle',
	'jwplayer.instance',
	'wikia.articleVideo.jwPlayerFeaturedVideoTracking'
], function (
	window,
	tracker,
	jwPlayerOnScroll,
	jwPlayerVideoFeedback,
	jwPlayerAutoplayToggle,
	playerInstance,
	jwPlayerFeaturedVideoTracking
) {
	var $featuredVideo = $('.featured-video'),
		$playerContainer = $('.featured-video__player-container');

	jwPlayerOnScroll(playerInstance, $featuredVideo, $playerContainer);
	jwPlayerVideoFeedback(playerInstance);
	jwPlayerAutoplayToggle(playerInstance);
	jwPlayerFeaturedVideoTracking(playerInstance);
});

