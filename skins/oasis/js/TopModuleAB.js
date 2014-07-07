jQuery( function() {
	'use strict';

	jQuery( '#WikiaRail' ).on( 'afterLoad.rail', function() {
		if ( window.wgUserName === null ) {
			var $wikiaActivityModule = jQuery( '.WikiaActivityModule.module' );

			jQuery.nirvana.sendRequest( {
				controller: 'WikiaSearch',
				method: 'topWikiArticles',
				format: 'html',
				type: 'GET',
				callback: function( response ) {
					var $topArticlesModule = jQuery( '<section class="module">' ),
						$response;

					if ( response ) {
						$response = jQuery( response );
						$response.find( '.top-wiki-main.header-test-2, .top-wiki-main.header-test-3' ).remove();
						$topArticlesModule.append( $response ).insertBefore( $wikiaActivityModule );
						$wikiaActivityModule.remove();
					}
				}
			} );
		}
	} );
} );
