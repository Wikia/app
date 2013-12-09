$( function () {
	'use strict';
	var rail = $( '#WikiaRail' ),
		LAZY_LOADING_SAMPLING_RATIO = 10, // integer (0-100): 0 - no tracking, 100 - track everything */
		params = {},
		lazyLoadingTime;


	if ( rail.find( '.loading' ).exists() ) {
		params = {
			'articleTitle': window.wgTitle,
			'namespace': window.wgNamespaceNumber,
			'cb': window.wgStyleVersion
		};

		if ( typeof wgSassLoadedScss !== 'undefined' ) {
			params.excludeScss = window.wgSassLoadedScss;
		}

		$.nirvana.sendRequest( {
			controller: 'RailController',
			method: (window.wgUserName) ? 'lazy' : 'lazyForAnons',
			data: params,
			type: 'get',
			format: 'json',
			callback: function ( data ) {
				var loadRailContents = function(data) {
					rail.find( '.loading' ).remove().end().append( data.railLazyContent + data.js );

					if ( LAZY_LOADING_SAMPLING_RATIO >= Math.floor( (Math.random() * 100 + 1) ) ) {
						lazyLoadingTime = ( new Date() ) - ( window.wgNow || 0 );

						Wikia.Tracker.track( {
							action: Wikia.Tracker.ACTIONS.IMPRESSION,
							category: 'right-rail',
							label: 'lazy-loaded',
							trackingMethod: 'ga',
							value: lazyLoadingTime
						} );
					}

					if ( window.ChatEntryPoint && typeof window.wgWikiaChatUsers !== 'undefined' ) {
						window.ChatEntryPoint.init();
					}

					// Fix any rail modules that use jQuery timeago (DAR-2344)
					if ( typeof $.fn.timeago !== 'undefined' ) {
						rail.find( '.timeago' ).timeago();
					}

					if ( window.Wikia && window.Wikia.initRailTracking ) {
						Wikia.initRailTracking();
					}

					if ( window.AIC2 ) {
						window.AIC2.init();
					}

					if ( window.wgEnableLightboxExt ) {
						window.LightboxLoader.init();
						window.LightboxLoader.loadFromURL();
					}
				};

				if ( data.css.length === 0 ) {
					loadRailContents( data );
				} else {
					require( ['wikia.loader'], function ( loader ) {
						loader( {
							type: loader.CSS,
							resources: data.css
						} ).done( function () {
							loadRailContents( data );
						} );
					} );
				}
			}
		} );
	}
} )
;
