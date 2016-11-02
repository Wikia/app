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
		var ima3LibUrl = '//imasdk.googleapis.com/js/sdkloader/ima3.js',
			containerId = vb.timeStampId(params.playerId),
			logGroup = 'wikia.videohandler.ooyala',
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

			if (typeof params.onCreate === 'function') {
				params.onCreate(player);
			}
		}

		function loadJs(resource) {
			return loader({
				type: loader.JS,
				resources: resource
			}).fail(loadFail);
		}

		function initRegularPlayer() {
			log('Create Ooyala player', log.levels.info, logGroup);

			win.OO.Player.create(containerId, params.videoId, createParams);
		}

		createParams.onCreate = onCreate;

		function getDartTagUrl() {
			if (!dartVideoHelper) {
				throw 'ext.wikia.adEngine.dartVideoHelper is not defined and it should as we need to display ads';
			}

			return dartVideoHelper.getUrl();
		}

		if (adContext && adContext.getContext().opts.showAds) {
			createParams.vast = {
				tagUrl: params.tagUrl || getDartTagUrl()
			};
		}

		// log any errors from failed script loading (VID-976)
		function loadFail(data) {
			var message = data.error + ':';

			$.each(data.resources, function () {
				message += ' ' + this;
			});

			log(message, log.levels.error, logGroup);
		}

		function initRecoveredPlayer() {
			log('Create recovered Ooyala player', log.levels.info, logGroup);

			win.googleImaSdkFailedCbList = {
				originalCbList: [],
				unshift: function (cb) {
					this.originalCbList.unshift(cb);
				}
			};
			ima3LibUrl = recoveryHelper.getSafeUri(ima3LibUrl);

			createParams.vast.tagUrl = recoveryHelper.getSafeUri(createParams.vast.tagUrl);

			loadJs(ima3LibUrl).done(function () {
				log('Recovered ima3 lib is loaded', log.levels.info, logGroup);

				initRegularPlayer();

				win.OO._.each(win.googleImaSdkLoadedCbList, function (fn) {
					fn();
				}, win.OO);
			}).fail(function() {
				log('Recovered ima3 lib failed to load', log.levels.info, logGroup);

				initRegularPlayer();

				win.OO._.each(win.googleImaSdkFailedCbList.originalCbList, function (fn) {
					fn();
				}, win.OO);
			});
		}

		// Only load the Ooyala player code once, Ooyala AgeGates will break if we load this asset more than once.
		if (win.OO !== undefined) {
			initRegularPlayer();
			return;
		}

		/* the second file depends on the first file */
		loadJs(params.jsFile[0]).done(function () {
			log('First set of Ooyala assets loaded', log.levels.info, logGroup);

			loadJs(params.jsFile[1]).done(function () {
				log('All Ooyala assets loaded', log.levels.info, logGroup);

				win.OO.ready(function () {
					if (recoveryHelper.isRecoveryEnabled()) {
						recoveryHelper.addOnBlockingCallback(initRecoveredPlayer);
						recoveryHelper.addOnNotBlockingCallback(initRegularPlayer);
					} else {
						initRegularPlayer();
					}
				});
			});
		});

	};
});
