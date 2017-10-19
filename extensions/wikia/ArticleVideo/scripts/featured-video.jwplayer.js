require([
	'mw',
	'wikia.articleVideo.featuredVideo.jwplayer.onScroll',
	'wikia.articleVideo.featuredVideo.jwplayer.videoFeedback',
	'wikia.articleVideo.featuredVideo.jwplayer.autoplayToggle',
	'wikia.articleVideo.featuredVideo.jwplayer.instance'
], function (
	mw,
	jwPlayerOnScroll,
	jwPlayerVideoFeedback,
	jwPlayerAutoplayToggle,
	playerInstance
) {
	var $featuredVideo = $('.featured-video'),
		$featuredVideoWrapper = $('.featured-video__wrapper'),
		$playerContainer = $('.featured-video__player-container');

	var unbindOnScrollEvents = jwPlayerOnScroll(playerInstance, $featuredVideo, $playerContainer);
	jwPlayerVideoFeedback(playerInstance);
	jwPlayerAutoplayToggle();

	// remove player if VisualEditor is loaded
	mw.hook('ve.activationComplete').add(function () {
		if (playerInstance) {
			$featuredVideoWrapper.addClass('is-removed');
			playerInstance.remove();
			playerInstance = null;
			unbindOnScrollEvents();
		}
	});
});
