jQuery( function() {
	'use strict';

	if ( !window.wgUserName ) {
		jQuery( '#WikiaRail' ).on( 'afterLoad.rail', function() {
			jQuery.nirvana.sendRequest( {
				controller: 'WikiaSearch',
				method: 'topWikiArticles',
				format: 'html',
				type: 'GET',
				callback: function( response ) {
					if ( response ) {
						var $wikiaActivityModule = jQuery( '.WikiaActivityModule.module' ),
							$topArticlesModule = jQuery( '<section class="module"></section>' ),
							$response = jQuery( response );

						// styling
						$response.find( '.top-wiki-main.header-test-2, .top-wiki-main.header-test-3' ).remove();
						$response.find( '.top-wiki-main.header-test-1' ).css( 'margin', '0 0 10px 0' );
						$response.find( '.top-wiki-article' ).css( 'float', 'left' ).css( 'margin', '0 0 10px 0' );
						$response.find( '.top-wiki-article-thumbnail' ).css( 'float', 'left' ).css( 'margin', '0 10px 0 0' );
						$response.find( '.top-wiki-article-text' ).css( 'float', 'left' ).css( 'font-size', '15px' ).css( 'width', '175px' );
						$response.find( '.top-wiki-article.hot-article' ).css( 'width', '270px' );
						$response.find( '.top-wiki-article.hot-article > .top-wiki-article-text' ).css( 'margin', '10px 0' ).css( 'width', '270px' );

						$topArticlesModule.append( $response ).insertBefore( $wikiaActivityModule );
						$wikiaActivityModule.remove();

						// TODO: tracking
					}
				}
			} );
		} );
	}
} );
