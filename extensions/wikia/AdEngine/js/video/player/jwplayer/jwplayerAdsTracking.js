/*global define*/
define('ext.wikia.adEngine.video.player.jwplayer.adsTracker', [
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

	function dispatchStatus(vastUrl, adInfo, status) {
		if (vastUrl.indexOf('https://pubads.g.doubleclick.net') === -1) {
			return;
		}
		if (!eventDispatcher) {
			return;
		}

		eventDispatcher.dispatch('adengine.video.status', {
			vastUrl: vastUrl,
			creativeId: adInfo.creativeId,
			lineItemId: adInfo.lineItemId,
			status: status
		});
	}

	return {
		track: function (params, eventName) {
			tracker.track(params, eventName);
		},

		register: function (player, params) {
			params.withCtp = !player.getConfig().autostart;
			params.withAudio = !player.getConfig().mute;

			tracker.track(params, 'init');

			player.on('videoStart', function () {
				clearParams(params);
			});

			player.on('adError', function (event) {
				dispatchStatus(event.tag, params, 'error');
				clearParams(params);
			});

			player.on('adRequest', function (event) {
				var currentAd = vastParser.getAdInfo(event.ima && event.ima.ad);

				params.lineItemId = currentAd.lineItemId;
				params.creativeId = currentAd.creativeId;
				params.contentType = currentAd.contentType;
			});

			player.on('adImpression', function (event) {
				dispatchStatus(event.tag, params, 'success');
			});

			tracker.register(player, params);
		}
	};
});

// We need to keep it in order to be compatible with adsTracking function on mobile-wiki
// TODO: Remove once we switch globally to AE3 on mobile-wiki
define('ext.wikia.adEngine.video.player.jwplayer.adsTracking', [
	'ext.wikia.adEngine.video.player.jwplayer.adsTracker'
], function (tracker) {
	return tracker.register;
});
