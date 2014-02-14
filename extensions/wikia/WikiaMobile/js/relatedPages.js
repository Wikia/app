require( [ 'wikia.window', 'wikia.nirvana', 'jquery', 'wikia.thumbnailer', 'lazyload', 'sloth', 'JSMessages', 'wikia.mustache' ],
function( window, nirvana, $, thumbnailer, lazyload, sloth, msg, mustache ) {
	'use strict';

	var sectionsList,
		sectionsLength,
		articleId = window.wgArticleId,
		testGroup = Wikia.AbTest.getGroup( 'WIKIAMOBILE_RELATEDPAGES' );

	if ( articleId && testGroup ) {
		sectionsList = $.makeArray(
			window.document.querySelectorAll('#mw-content-text h2[id]:not(:first-of-type):not(:last-of-type)' )
		).filter( function( section ){
			//TODO: Filter sections shorter than 1000px
			return true;
		} );
		sectionsLength = sectionsList.length;

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
						imgUrl;

					for(; i < l; i++) {
						item = items[i];
						imgUrl = item.imgUrl ?
							thumbnailer.getThumbURL( item.imgUrl, 'image', width, height ) :
							false;

						sectionsList[i].insertAdjacentHTML( 'beforebegin', mustache.render( template, {
							url: item.url,
							title: item.title,
							img: imgUrl
						} ) );
					}

					sloth( {
						on: document.querySelectorAll( '.related-article .lazy:not(.placeholder)' ),
						threshold: 400,
						callback: lazyload
					} );
				});
			});
		}
	}
});
