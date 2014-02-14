require( [ 'sloth', 'wikia.window', 'jquery' ], function ( sloth, w, $ ) {
	'use strict';

	var $placeholder,
		cacheKey = 'RelatedPagesAssets',
		articleId = w.wgArticleId,
		loaded,
		shouldLoad;

	switch ( w.skin ) {
		case 'oasis':
			$placeholder = $( '#WikiaArticleFooter' );
			break;
		case 'monobook':
			$placeholder = $( '#mw-data-after-content' );
			break;
	}

	shouldLoad = $placeholder.length && articleId;

	/**
	 * Checks if template is cached in LocalStorage and if not loads it by using loader
	 * @returns {$.Deferred}
	 */
	function loadTemplate () {
		var dfd = new $.Deferred();

		require( ['wikia.loader', 'wikia.cache'], function ( loader, cache ) {
			var template = cache.getVersioned( cacheKey );

			if ( template ) {
				dfd.resolve( template );
			} else {
				loader( {
					type: loader.MULTI,
					resources: {
						ttl: 604800, // 7 days
						mustache: 'extensions/wikia/RelatedPages/templates/RelatedPages_section.mustache'
					}
				} ).done( function ( data ) {
					template = data.mustache[0];

					dfd.resolve( template );

					cache.setVersioned( cacheKey, template, 604800 ); //7days
				} );
			}

		} );

		return dfd.promise();
	}

	function load () {
		if ( !loaded && articleId ) {
			require( [
				'wikia.mustache',
				'JSMessages',
				'wikia.nirvana',
				'wikia.tracker'
			],
				function ( mustache, msg, nirvana, tracker ) {
					$.when(
						nirvana.getJson(
							'RelatedPagesApi',
							'getList',
							{ ids: [articleId] }
						),
						loadTemplate()
					).done( function ( data, template ) {
						var items = data[0] && data[0].items,
							pages = items && items[articleId],
							page,
							relatedPages = [];

						if ( pages && pages.length ) {
							while( ( page = pages.shift() ) ) {
								relatedPages.push( {
									url: page.url,
									title: page.title,
									imgUrl: page.imgUrl || '',
									text: page.text
								} );
							}

							$placeholder.prepend(
								mustache.render( template, {
									relatedPagesHeading: msg( 'wikiarelatedpages-heading' ),
									imgWidth: 200,
									imgHeight:  100,
									pages: relatedPages
								} )
							)
							.on( 'mousedown', '.RelatedPagesModule a', function ( event ) {
								// Primary mouse button only
								if ( event.type === 'mousedown' && event.which !== 1 ) {
									return;
								}

								tracker.track( {
									action: tracker.ACTIONS.CLICK,
									trackingMethod: 'ga',
									category: 'article',
									label: 'related-pages'
								} );
							} );
						}
					} );
				}
			);

			loaded = true;
		}
	}

	if ( shouldLoad ) {
		sloth( {
			on: $placeholder,
			threshold: 200,
			callback: load
		} );
	}
} );
