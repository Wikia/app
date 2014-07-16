// this is the shared JS part
( function() {
	'use strict';

	window.initTopArticlesSwapABTest = function( variationId ) {
		jQuery( '#WikiaRail' ).on( 'afterLoad.rail', function() {
			var $wikiaActivityModule = jQuery( '.WikiaActivityModule.module' ),
				variationModuleNames = [ 'wiki-activity-1', 'wiki-activity-2', 'top-articles-1', 'top-articles-2' ],
				trackClickABTest = function( element, variationName ) {
					element.on( 'mousedown', 'a', function() {
						window.optimizely.push( [ 'trackEvent', variationName + '-click' ] );
						window.Wikia.Tracker.track( {
							action: window.Wikia.Tracker.ACTIONS.CLICK,
							trackingMethod: 'ga',
							category: 'consumer-top-vs-wiki-activity',
							label: 'consumer-' + variationName + '-click'
						} );
					} );
				};

			// track impression
			window.optimizely.push( [ 'trackEvent', variationModuleNames[ variationId ] + '-impression' ] );
			window.Wikia.Tracker.track( {
				action: window.Wikia.Tracker.ACTIONS.IMPRESSION,
				trackingMethod: 'ga',
				category: 'consumer-top-vs-wiki-activity',
				label: 'consumer-' + variationModuleNames[ variationId ] + '-impression'
			} );

			if ( variationId >= 2 ) {
				jQuery.nirvana.sendRequest( {
					controller: 'WikiaSearch',
					method: 'topWikiArticles',
					format: 'html',
					type: 'GET',
					callback: function( response ) {
						if ( response ) {
							var $topArticlesModule = jQuery( '<section class="module"></section>' ),
								$insertPlace = ( variationId === 3 ) ? $( '#videosModule' ) : $wikiaActivityModule,
								$response = jQuery( response );

							$response.find( '.top-wiki-main.header-test-2, .top-wiki-main.header-test-3' ).hide();

							// styling
							$response.find( '.top-wiki-main.header-test-1' )
								.css( 'margin', '0 0 10px 0' )
								.end().find( '.top-wiki-article' )
								.css( { 'float': 'left', 'margin': '0 0 10px 0' } )
								.end().find( '.top-wiki-article-thumbnail' )
								.css( { 'float': 'left', 'margin': '0 10px 0 0' } )
								.end().find( '.top-wiki-article-text' )
								.css( { 'float': 'left', 'font-size': '15px', 'width': '175px' } )
								.end().find( '.top-wiki-article.hot-article' )
								.css( 'width', '270px' )
								.end().find( '.top-wiki-article.hot-article .top-wiki-article-text' )
								.css( { 'margin': '10px 0', 'width': '270px' } );

							$topArticlesModule.append( $response ).insertBefore( $insertPlace );

							trackClickABTest( $topArticlesModule, variationModuleNames[ variationId ] );
						}
					}
				} );
				$wikiaActivityModule.hide();
			} else {
				trackClickABTest( $wikiaActivityModule, variationModuleNames[ variationId ] );
			}
		} );
	};
} )();


// this is how the code is run across the variations
// function argument can have values from 0 to 3
( function () {
	'use strict';
	window.initTopArticlesSwapABTest( 3 );
} )();
