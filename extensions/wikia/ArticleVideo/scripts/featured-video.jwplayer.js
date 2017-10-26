require([
	'mw',
	'wikia.window',
	'wikia.articleVideo.featuredVideo.jwplayer.onScroll',
	'wikia.articleVideo.featuredVideo.jwplayer.videoFeedback',
	require.optional('wikia.articleVideo.featuredVideo.jwplayer.instance')
], function (mw,
             win,
             jwPlayerOnScroll,
             jwPlayerVideoFeedback,
             playerInstance) {
	var $featuredVideo = $('.featured-video'),
		$featuredVideoWrapper = $('.featured-video__wrapper'),
		$playerContainer = $('.featured-video__player-container');

	function run() {
		var unbindOnScrollEvents = jwPlayerOnScroll(playerInstance, $featuredVideo, $playerContainer);
		jwPlayerVideoFeedback(playerInstance);

		// remove player if VisualEditor is loaded
		mw.hook('ve.activationComplete').add(function () {
			if (playerInstance) {
				$featuredVideoWrapper.addClass('is-removed');
				playerInstance.remove();
				playerInstance = null;
				unbindOnScrollEvents();
			}
		});
	}

	// `wikia.articleVideo.featuredVideo.jwplayer.instance` module is defined asynchronously
	// so when it's not yet available we listen for custom event to get player instance object
	if (playerInstance) {
		run();
	} else {
		win.addEventListener('wikia.jwplayer.instanceReady', function (event) {
			playerInstance = event.detail;
			win.removeEventListener('wikia.jwplayer.instanceReady', arguments.callee);
			run();
		});
	}
});
