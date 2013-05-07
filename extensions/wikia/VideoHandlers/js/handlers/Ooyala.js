/*global define*/
define('wikia.ooyala', ['wikia.window', 'ext.wikia.adengine.dartvideohelper'], function(window, dartVideoHelper) {
	'use strict';

	return function(params, vb) {
		var containerId = vb.timeStampId( params.playerId ),
			createParams = { width: params.width + 'px', height: params.height + 'px', autoplay: params.autoPlay, onCreate: onCreate };

		if (window.wgAdVideoTargeting && window.wgShowAds) {
			createParams['google-ima-ads-manager'] = {
				adTagUrl: dartVideoHelper.getUrl(),
				showInAdControlBar : true
			};
		}

		function onCreate(player) {
			var messageBus = player.mb;

			// Player has loaded
			messageBus.subscribe(OO.EVENTS.PLAYER_CREATED, 'tracking', function(eventName, payload) {
				vb.track('player-load');
			});

			// Actual content starts playing (past any ads or age-gates)
			messageBus.subscribe(OO.EVENTS.PLAYING, 'tracking', function() {
				vb.track('content-begin');

			});

			// Ad starts
			messageBus.subscribe(OO.EVENTS.WILL_PLAY_ADS, 'tracking', function(eventName, payload) {
				vb.track('ad-start');
			});

			// Ad has been fully watched
			messageBus.subscribe(OO.EVENTS.ADS_PLAYED, 'tracking', function(eventName, payload) {
				vb.track('ad-finish');
			});

			// Log all events and values (for debugging)
			/*messageBus.subscribe('*', 'tracking', function(eventName, payload) {
				console.log(eventName);
				console.log(payload);
			});*/

		}

		window.OO.Player.create(containerId, params.videoId, createParams);
	};
});
