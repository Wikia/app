/**
 * Module that handles related pages that are lazy loaded and added at the end of sections
 * that are longer than 1000px
 *
 * there is currently AB Test running with 4 groups
 * After tests this will be much simplified file
 */
require( [ 'wikia.window', 'wikia.nirvana', 'jquery', 'wikia.thumbnailer', 'lazyload', 'sloth', 'JSMessages', 'wikia.mustache', 'sections', 'track' ],
function( window, nirvana, $, thumbnailer, lazyload, sloth, msg, mustache, sections, track ) {
	'use strict';

	var sectionsList,
		sectionsLength,
		articleId = window.wgArticleId,
		testGroup = Wikia.AbTest.getGroup( 'WIKIAMOBILE_RELATEDPAGES' ),
		minSectionLength = 1000,
		$placeholder = $( '#RelatedPagesModuleWrapper' ),
		cacheKey = 'RelatedPagesAssets',
		loaded,
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
				'wikia.nirvana',
				'wikia.tracker'
			],
			function ( mustache, nirvana, tracker ) {
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
								imgUrl: page.imgUrl || window.wgExtensionsPath +
									'/wikia/WikiaMobile/images/read_placeholder.png',
								text: page.text
							} );
						}

						$placeholder.prepend(
								mustache.render( template, {
									relatedPagesHeading: msg( 'wikiarelatedpages-heading' ),
									imgWidth: 100,
									imgHeight: 50,
									pages: relatedPages,
									mobileSkin: true
								} )
							)
							.on( 'mousedown', '.RelatedPagesModule a', function ( event ) {
								// Primary mouse button only
								if ( event.type === 'mousedown' && event.which !== 1 ) {
									return;
								}

								tracker.track( {
									action: tracker.ACTIONS.CLICK,
									trackingMethod: 'analytics',
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

	if ( articleId ) {
		if ( testGroup ) {
			sectionsList = $.makeArray(
				window.document.querySelectorAll('#mw-content-text h2[id]:not(:last-of-type)' )
			).filter( function( section ){
				return sections.isSectionLongerThan( section, minSectionLength );
			} );
			sectionsLength = sectionsList.length;

			$( '.trending-articles' )
				.removeClass( 'hidden' )
				.find( 'h2' )
				.attr( 'id', 'trendingArticles' );

			if ( sectionsLength ) {
				$( window ).on(' load', function(){
					$.when(
						nirvana.getJson(
							'RelatedPagesApi',
							'getList',
							{
								ids: [ articleId ],
								limit: sectionsLength
							}
						),
						msg.get( 'RelatedPagesInContent' )
					).done( function( data ){
						var items = data[0].items[articleId],
							l = Math.min( sectionsLength, items.length ),
							i = 0,
							styleClass = (['C', 'D'].indexOf( testGroup ) > -1) ? 'small' : 'large',
							isSmall = ( styleClass === 'small' ),
							width = isSmall ?  136 : 280,
							height = isSmall ? 76 : 158,
							emptyGif = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
							header = (['B', 'D'].indexOf( testGroup ) > -1) ?
								msg( 'wikiamobile-people-also-read' ) :
								msg( 'wikiamobile-related-article' ),
							template = '<a href="{{url}}" class="related-article ' +
								styleClass +
								'"><div class="header">' +
								header +
								'</div><img class="lazy link{{^img}} placeholder{{/img}}" ' +
								'src="' + emptyGif + '" data-src="{{img}}" width="' +
								width +
								'px" height="' +
								height +
								'px" /><div class="title">{{title}}</div></a>',
							item,
							imgUrl,
							next;

						for(; i < l; i++) {
							item = items[i];
							imgUrl = item.imgUrl ?
								thumbnailer.getThumbURL( item.imgUrl, 'image', width, height ) :
								false;

							next = sections.getNext( sectionsList[i] );

							if ( next ) {
								next.insertAdjacentHTML( 'beforebegin', mustache.render( template, {
									url: item.url,
									title: item.title,
									img: imgUrl
								} ) );
							}
						}

						sloth( {
							on: document.querySelectorAll( '.related-article .lazy:not(.placeholder)' ),
							threshold: 400,
							callback: lazyload
						} );

						$( '#mw-content-text' ).on( 'click', '.related-article', function( event ){
							track.event(
								'related-article',
								track.IMAGE_LINK,
								{
									method: 'ga',
									href: this.href,
									label: 'section_' + ( sections.getId( this.nextSibling ) )
								},
								event
							);
						} );
					});
				});
			}
		} else {
			if ( shouldLoad ) {
				sloth( {
					on: $placeholder,
					threshold: 400,
					callback: load
				} );
			}
		}
	}
});
