/**
 * Use Ooyala V3 player API to play and track videos
 * Uses player events to track video views
 *
 * @see http://support.ooyala.com/developers/documentation
 */

/*global define, require*/
define('wikia.ooyala', ['wikia.window', require.optional('ext.wikia.adengine.dartvideohelper')], function(window, dartVideoHelper) {
	'use strict';

	/**
	 * Set up Ooyala player and tracking events
	 * @param {Object} params Player params sent from the video handler
	 * @param {VideoBootstrap} vb Instance of video player
	 */
	return function(params, vb) {
		var containerId = vb.timeStampId( params.playerId ),
			createParams = { width: params.width + 'px', height: params.height + 'px', autoplay: params.autoPlay };

		function onCreate(player) {
			var messageBus = player.mb;

			// Player has loaded
			messageBus.subscribe(window.OO.EVENTS.PLAYER_CREATED, 'tracking', function(eventName, payload) {
				vb.track('player-load');
			});

			// Actual content starts playing (past any ads or age-gates)
			messageBus.subscribe(window.OO.EVENTS.PLAYING, 'tracking', function() {
				vb.track('content-begin');

			});

			// Ad starts
			messageBus.subscribe(window.OO.EVENTS.WILL_PLAY_ADS, 'tracking', function(eventName, payload) {
				vb.track('ad-start');
			});

			// Ad has been fully watched
			messageBus.subscribe(window.OO.EVENTS.ADS_PLAYED, 'tracking', function(eventName, payload) {
				vb.track('ad-finish');
			});

			// Log all events and values (for debugging)
			/*messageBus.subscribe('*', 'tracking', function(eventName, payload) {
				console.log(eventName);
				console.log(payload);
			});*/

		}

		createParams.onCreate = onCreate;

		if (window.wgAdVideoTargeting && window.wgShowAds) {
			if (!dartVideoHelper) {
				throw 'ext.wikia.adengine.dartvideohelper is not defined and it should as we need to display ads';
			}
			createParams['google-ima-ads-manager'] = {
				adTagUrl: dartVideoHelper.getUrl(),
				showInAdControlBar : true
			};
		}

		window.OO.Player.create(containerId, params.videoId, createParams);
	};
});
