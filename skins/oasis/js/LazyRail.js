$(function() {
	'use strict';
	var rail = $('#WikiaRail'),
	LAZY_LOADING_SAMPLING_RATIO = 10; // integer (0-100): 0 - no tracking, 100 - track everything */

	if (rail.find('.loading').exists()) {
		$.nirvana.sendRequest({
			controller: 'RailController',
			method: (window.wgUserName) ? 'lazy' : 'lazyForAnons',
			data: {
				'title': window.wgTitle,
				'namespace': window.wgNamespaceNumber,
				'cb': window.wgStyleVersion
			},
			type: 'get',
			format: 'json',
			callback: function(data) {
				require(['wikia.loader'], function(loader) {
					loader({
						type: loader.CSS,
						resources: data.css
					});
				});

				$('#WikiaRail').find('.loading').remove().end().append(data.railLazyContent + data.js);

				if( LAZY_LOADING_SAMPLING_RATIO >= Math.floor( (Math.random() * 100 + 1) ) ) {
					var lazyLoadingTime = ( new Date() ) - ( window.wgNow || 0 );
					Wikia.Tracker.track({
						action: Wikia.Tracker.IMPRESSION,
						category: 'right-rail',
						label: 'lazy-loaded',
						trackingMethod: 'ga',
						value: lazyLoadingTime
					});
				}

				if ( window.ChatEntryPoint ) {
					window.ChatEntryPoint.init();
				}

				if ( window.Wikia && window.Wikia.initRailTracking ) {
					Wikia.initRailTracking();
				}

				if ( !window.wgUserName ) {
					window.AIC2.init();
				}

				if (window.wgEnableLightboxExt) {
					LightboxLoader.init();
					LightboxLoader.loadFromURL();
				}
			}
		});
	}
});
