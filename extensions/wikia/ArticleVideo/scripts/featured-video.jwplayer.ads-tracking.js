define('wikia.articleVideo.featuredVideo.adsTracking', [
	'ext.wikia.adEngine.utils.eventDispatcher',
	'ext.wikia.adEngine.video.player.jwplayer.jwplayerTracker'
], function (eventDispatcher, tracker) {
	function clearParams(params) {
		params.lineItemId = undefined;
		params.creativeId = undefined;
		params.contentType = undefined;
	}

	function updateParams(params, currentAd) {
		var wrapperCreativeId,
			wrapperId;

		if (currentAd) {
			params.lineItemId = currentAd.getAdId();
			params.creativeId = currentAd.getCreativeId();
			params.contentType = currentAd.getContentType();

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
			clearParams(params);
		});

		player.on('adError', function () {
			clearParams(params);
		});

		player.on('adRequest', function (event) {
			updateParams(params, event.ima && event.ima.ad);
		});

		player.on('adImpression', function (event) {
			if (eventDispatcher) {
				eventDispatcher.dispatch('adengine.video.status', {
					vastUrl: event.tag,
					creativeId: params.creativeId,
					lineItemId: params.lineItemId,
					status: 'success'
				});
			}
		});

		tracker.register(player, params);
	};
});
