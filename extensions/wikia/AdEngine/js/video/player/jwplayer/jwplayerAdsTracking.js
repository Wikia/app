define('ext.wikia.adEngine.video.player.jwplayer.adsTracking', [
	'ext.wikia.adEngine.utils.eventDispatcher',
	'ext.wikia.adEngine.video.player.jwplayer.jwplayerTracker',
	'ext.wikia.adEngine.video.vastParser'
], function (eventDispatcher, tracker, vastParser) {
	'use strict';

	function clearParams(params) {
		params.lineItemId = undefined;
		params.creativeId = undefined;
		params.contentType = undefined;
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
			var currentAd = vastParser.getAdInfo(event.ima && event.ima.ad);

			params.lineItemId = currentAd.lineItemId;
			params.creativeId = currentAd.creativeId;
			params.contentType = currentAd.contentType;
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
