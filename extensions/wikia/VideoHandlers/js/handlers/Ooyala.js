/*global define, require*/

/**
 * Use Ooyala V3 player API to play and track videos
 * Uses player events to track video views.
 *
 * @see http://support.ooyala.com/developers/documentation
 */

define('wikia.videohandler.ooyala', [
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'jquery',
	'wikia.window',
	require.optional('ext.wikia.adEngine.adContext'),
	require.optional('ext.wikia.adEngine.dartVideoHelper'),
	'wikia.loader',
	'wikia.log'
], function (recoveryHelper, $, win, adContext, dartVideoHelper, loader, log) {
	'use strict';

	/**
	 * Set up Ooyala player and tracking events
	 * @param {Object} params Player params sent from the video handler
	 * @param {Constructor} vb Instance of video player
	 */
	return function (params, vb) {
		var ima3LibUrl = 'https://imasdk.googleapis.com/js/sdkloader/ima3.js',
			containerId = vb.timeStampId(params.playerId),
			started = false,
			createParams = {
				width: vb.width + 'px',
				height: vb.height + 'px',
				autoplay: params.autoPlay,
				wmode: 'transparent'
			};

		function onCreate(player) {
			var messageBus = player.mb;

			// Player has loaded
			messageBus.subscribe(win.OO.EVENTS.PLAYER_CREATED, 'tracking', function () {
				vb.track('player-load');
			});

			// Actual content starts playing (past any ads or age-gates)
			messageBus.subscribe(win.OO.EVENTS.PLAYING, 'tracking', function () {
				if (!started) {
					vb.track('content-begin');
					started = true;
				}

			});

			// Ad starts
			messageBus.subscribe(win.OO.EVENTS.WILL_PLAY_ADS, 'tracking', function () {
				vb.track('ad-start');
			});

			// Ad has been fully watched
			messageBus.subscribe(win.OO.EVENTS.ADS_PLAYED, 'tracking', function () {
				vb.track('ad-finish');
			});

			// Listen GoogleIma event to fill adTagUrl for no-flash scenario
			messageBus.subscribe('googleImaReady', 'tracking', function () {
				var i;
				if (player && player.modules && player.modules.length) {
					for (i = 0; i < player.modules.length; i = i + 1) {
						if (player.modules[i].name === "GoogleIma" && player.modules[i].instance) {
							player.modules[i].instance.adTagUrl = createParams.vast.tagUrl;
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

		function initRegularPlayer() {
			win.OO.Player.create(containerId, params.videoId, createParams);
		}

		createParams.onCreate = onCreate;

		if (adContext && adContext.getContext().opts.showAds) {
			if (!dartVideoHelper) {
				throw 'ext.wikia.adEngine.dartVideoHelper is not defined and it should as we need to display ads';
			}

			createParams.vast = {
				tagUrl: dartVideoHelper.getUrl()
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

		function initRecoveredPlayer() {
			win.googleImaSdkFailedCbList = {
				unshift: function () {
				}
			};
			ima3LibUrl = recoveryHelper.getSafeUri(ima3LibUrl);

			createParams.vast.tagUrl = recoveryHelper.getSafeUri(createParams.vast.tagUrl);

			loader({
				type: loader.JS,
				resources: ima3LibUrl
			}).done(function () {
				log('Ooyala OO.ready', log.levels.info, 'VideoBootstrap');
				initRegularPlayer();

				if (recoveryHelper.isBlocking()) {
					win.OO._.each(win.googleImaSdkLoadedCbList, function (fn) {
						fn();
					}, win.OO);
				}
			});
		}

		function initPlayer () {
			recoveryHelper.isBlocking() ? initRecoveredPlayer() : initRegularPlayer();
		}

		// Only load the Ooyala player code once, Ooyala AgeGates will break if we load this asset more than once.
		if ( win.OO !== undefined ) {
			initRegularPlayer();
			return;
		}

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

				win.OO.ready(function () {
					recoveryHelper.isRecoveryEnabled() ?
						recoveryHelper.runAfterDetection(initPlayer) : initRegularPlayer();
				});

			}).fail( loadFail );
		}).fail( loadFail );

	};
});
