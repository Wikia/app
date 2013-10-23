/**
 * Use Ooyala V3 player API to play and track videos
 * Uses player events to track video views
 *
 * @see http://support.ooyala.com/developers/documentation
 */

/*global define, require*/
define( 'wikia.videohandler.ooyala', [ 'wikia.window', require.optional( 'ext.wikia.adengine.dartvideohelper' ), 'wikia.loader', 'wikia.log' ], function( window, dartVideoHelper, loader, log ) {
	'use strict';

	/**
	 * Set up Ooyala player and tracking events
	 * @param {Object} params Player params sent from the video handler
	 * @param {Constructor} vb Instance of video player
	 */
	return function( params, vb ) {
		var containerId = vb.timeStampId( params.playerId ),
			started = false,
			createParams = {
				width: params.width + 'px',
				height: params.height + 'px',
				autoplay: params.autoPlay,
				wmode: 'transparent'
			};

		function onCreate( player ) {
			var messageBus = player.mb;

			// Player has loaded
			messageBus.subscribe( window.OO.EVENTS.PLAYER_CREATED, 'tracking', function( eventName, payload ) {
				vb.track( 'player-load' );
			});

			// Actual content starts playing (past any ads or age-gates)
			messageBus.subscribe( window.OO.EVENTS.PLAYING, 'tracking', function() {
				if ( !started ) {
					vb.track( 'content-begin' );
					started = true;
				}

			});

			// Ad starts
			messageBus.subscribe( window.OO.EVENTS.WILL_PLAY_ADS, 'tracking', function( eventName, payload ) {
				vb.track('ad-start');
			});

			// Ad has been fully watched
			messageBus.subscribe( window.OO.EVENTS.ADS_PLAYED, 'tracking', function( eventName, payload ) {
				vb.track( 'ad-finish' );
			});

			// Log all events and values (for debugging)
			/*messageBus.subscribe('*', 'tracking', function(eventName, payload) {
				console.log(eventName);
				console.log(payload);
			});*/

		}

		createParams.onCreate = onCreate;

		if ( window.wgAdVideoTargeting && window.wgShowAds ) {
			if ( !dartVideoHelper ) {
				throw 'ext.wikia.adengine.dartvideohelper is not defined and it should as we need to display ads';
			}
			createParams[ 'google-ima-ads-manager' ] = {
				adTagUrl: dartVideoHelper.getUrl(),
				showInAdControlBar : true
			};
		}

		// log any errors from failed script loading
		function loadFail( data ) {
			var message = data.error + ':';

			$.each( data.resources, function() {
				message += ' ' + this;
			});

			log( message, log.levels.error, 'VideoBootstrap' );
		}

		/* Ooyala doesn't support more than one player type (i.e. age-gate and non-age-gate)
		 * per page load unless we delete window.OO before we reload the player script.
		 *
		 * If they ever fix this we can remove this hack and load params.jsFile with
		 * video bootstrap
		 */
		delete window.OO;

		/* the second file depends on the first file */
		loader({
			type: loader.JS,
			resources: params.jsFile[ 0 ]
		}).done(function() {
			loader({
				type: loader.JS,
				resources: params.jsFile[ 1 ]
			}).done(function() {
				window.OO.Player.create( containerId, params.videoId, createParams );
			}).fail( loadFail );
		}).fail( loadFail );

	};
});
