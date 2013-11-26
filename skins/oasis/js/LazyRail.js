$(function() {
	'use strict';
	var rail = $('#WikiaRail'),
	LAZY_LOADING_SAMPLING_RATIO = 10; // integer (0-100): 0 - no tracking, 100 - track everything */

	if (rail.find('.loading').exists()) {
		var params = {
			'articleTitle': window.wgTitle,
			'namespace': window.wgNamespaceNumber,
			'cb': window.wgStyleVersion
		};

		if (typeof wgSassLoadedScss != 'undefined') {
			params.excludeScss = wgSassLoadedScss;
		}

		$.nirvana.sendRequest({
			controller: 'RailController',
			method: (window.wgUserName) ? 'lazy' : 'lazyForAnons',
			data: params,
			type: 'get',
			format: 'json',
			callback: function(data) {
				var zidConfig = { minColumnWidth: 350, selector: '.module, .wikia-ad',
					onColumnCountChangeCallback: function ( columnsCount, elements ) {

						// Fix for DAR-2983: We need to hide wikia-ad element BEFORE we re-calculate columns in ZID.
						// AdEng is already hiding / showing them, but events are being fired in random order and it
						// cannot be determined. We're hiding/showing container just to be sure.

						$.each( elements, function ( i, v ) {
							var elem = $(v);
							if ( elem.hasClass( 'wikia-ad' ) ) {
								if ( columnsCount > 1 ) {
									elem.hide();
								} else {
									elem.show();
								}
							}
						} );
					} };

				rail.find('.loading').remove().end().append(data.railLazyContent + data.js);

				if ( data.css.length === 0 ) {
					// we can enable zid immediately when there are no styles to load
					rail.zid(zidConfig);
				} else {
					require(['wikia.loader'], function(loader) {
						loader({
							type: loader.CSS,
							resources: data.css
						}).done(function() {
							rail.zid(zidConfig);
						});
					});
				}

				if( LAZY_LOADING_SAMPLING_RATIO >= Math.floor( (Math.random() * 100 + 1) ) ) {
					var lazyLoadingTime = ( new Date() ) - ( window.wgNow || 0 );
					Wikia.Tracker.track({
						action: Wikia.Tracker.ACTIONS.IMPRESSION,
						category: 'right-rail',
						label: 'lazy-loaded',
						trackingMethod: 'ga',
						value: lazyLoadingTime
					});
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
					LightboxLoader.init();
					LightboxLoader.loadFromURL();
				}
			}
		});
	}
});
