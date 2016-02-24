/*global define, require*/

/**
 * Use Ooyala V3 player API to play and track videos
 * Uses player events to track video views.
 *
 * @see http://support.ooyala.com/developers/documentation
 */

define('wikia.videohandler.ooyala', [
	'jquery',
	'wikia.window',
	require.optional('ext.wikia.adEngine.adContext'),
	require.optional('ext.wikia.adEngine.dartVideoHelper'),
	'wikia.loader',
	'wikia.log'
], function ($, window, adContext, dartVideoHelper, loader, log) {
	'use strict';

	/**
	 * Set up Ooyala player and tracking events
	 * @param {Object} params Player params sent from the video handler
	 * @param {Constructor} vb Instance of video player
	 */
	return function (params, vb) {
		var containerId = vb.timeStampId(params.playerId),
			started = false,
			tagUrl,
			createParams = {
				width: vb.width + 'px',
				height: vb.height + 'px',
				autoplay: params.autoPlay,
				wmode: 'transparent'
			};

		function onCreate(player) {
			var messageBus = player.mb;

			// Player has loaded
			messageBus.subscribe(window.OO.EVENTS.PLAYER_CREATED, 'tracking', function () {
				vb.track('player-load');
			});

			// Actual content starts playing (past any ads or age-gates)
			messageBus.subscribe(window.OO.EVENTS.PLAYING, 'tracking', function () {
				if (!started) {
					vb.track('content-begin');
					started = true;
				}

			});

			// Ad starts
			messageBus.subscribe(window.OO.EVENTS.WILL_PLAY_ADS, 'tracking', function () {
				vb.track('ad-start');
			});

			// Ad has been fully watched
			messageBus.subscribe(window.OO.EVENTS.ADS_PLAYED, 'tracking', function () {
				vb.track('ad-finish');
			});

			// Listen GoogleIma event to fill adTagUrl for no-flash scenario
			messageBus.subscribe('googleImaReady', 'tracking', function () {
				var i;
				if (player && player.modules && player.modules.length) {
					for (i = 0; i < player.modules.length; i = i + 1) {
						if (player.modules[i].name === "GoogleIma" && player.modules[i].instance) {
							player.modules[i].instance.adTagUrl = tagUrl;
						}
					}
				}
			});

			// Log all events and values (for debugging)
			/*messageBus.subscribe('*', 'tracking', function(eventName, payload) {
				console.log(eventName);
				console.log(payload);
			});*/
		}

		createParams.onCreate = onCreate;

		if (adContext && adContext.getContext().opts.showAds) {
			if (!dartVideoHelper) {
				throw 'ext.wikia.adEngine.dartVideoHelper is not defined and it should as we need to display ads';
			}

			tagUrl = dartVideoHelper.getUrl();

			createParams.vast = {
				tagUrl: tagUrl
			};
		}

		// log any errors from failed script loading (VID-976)
		function loadFail( data ) {
			var message = data.error + ':';

			$.each( data.resources, function() {
				message += ' ' + this;
			});

			log( message, log.levels.error, 'VideoBootstrap' );
		}

		// Only load the Ooyala player code once, Ooyala AgeGates will break if we load this asset more than once.
		if ( window.OO === undefined ) {
			/* the second file depends on the first file */
			loader({
				type: loader.JS,
				resources: params.jsFile[ 0 ]
			}).done(function() {
				log( 'First set of Ooyala assets loaded', log.levels.info, 'VideoBootstrap' );
				loader({
					type: loader.JS,
					resources: params.jsFile[ 1 ]
				}).done(function() {
					log( 'All Ooyala assets loaded', log.levels.info, 'VideoBootstrap' );

					window.OO.ready(function (OO) {
						log( 'Ooyala OO.ready', log.levels.info, 'VideoBootstrap' );
						OO.Player.create( containerId, params.videoId, createParams );
					});

				}).fail( loadFail );
			}).fail( loadFail );
		} else {
			window.OO.Player.create( containerId, params.videoId, createParams );
		}

	};
});
