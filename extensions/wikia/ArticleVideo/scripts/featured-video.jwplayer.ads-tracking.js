define('wikia.articleVideo.featuredVideo.adsTracking', [
	'ext.wikia.adEngine.video.player.jwplayer.jwplayerTracker'
], function (tracker) {
	function updateParams(params, currentAd) {
		var wrapperCreativeId,
			wrapperId;

		if (currentAd) {
			params.lineItemId = currentAd.getAdId();
			params.creativeId = currentAd.getCreativeId();

			wrapperId = currentAd.getWrapperAdIds();
			if (wrapperId.length) {
				params.lineItemId = wrapperId[0];
			}

			wrapperCreativeId = currentAd.getWrapperCreativeIds();
			if (wrapperCreativeId.length) {
				params.creativeId = wrapperCreativeId[0];
			}
		}
	}

	return function(player, params) {
		tracker.track(params, 'init');

		player.on('adComplete', function () {
			params.lineItemId = undefined;
			params.creativeId = undefined;
		});
		player.on('adError', function () {
			updateParams(params);
		});
		player.on('adRequest', function (event) {
			updateParams(params, event.ima && event.ima.ad);
		});

		tracker.register(player, params);
	};
});
