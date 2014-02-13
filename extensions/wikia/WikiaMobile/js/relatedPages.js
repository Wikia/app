require( [ 'wikia.window', 'wikia.nirvana', 'jquery', 'wikia.thumbnailer', 'lazyload', 'sloth', 'JSMessages' ], function( window, nirvana, $, thumbnailer, lazyload, sloth, msg ) {
	var sectionsList = $.makeArray(
			window.document.querySelectorAll('#mw-content-text h2[id]:not(:first-of-type):not(:last-of-type)' )
		).filter( function( section ){
			//TODO: Filter sections shorter than 1000px
			return true;
		} ),
		sectionsLength = sectionsList.length,
		articleId = window.wgArticleId,
		testGroup = 'C',// && 'B' && 'C' && 'D',
		largeStyle = (['A', 'B'].indexOf( testGroup ) > -1),
		width = largeStyle ? 280 : 136,
		height = largeStyle ? 158 : 76,
		template = function( item ){
			var header = (['A', 'C'].indexOf( testGroup ) > -1) ? msg( 'wikiamobile-related-article' ) : msg( 'wikiamobile-people-also-read' );

			return '<a href="'+ item.url +'" class="related-article ' + ( largeStyle ? 'large' : 'small') + '"><div class="header">' +
				header +
				'</div><img class="lazy link" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' +
				(item.imgUrl ? thumbnailer.getThumbURL(item.imgUrl, 'image', width, height) : '!!!') +
				'" width="' + width+'px" height="' + height + 'px"><div class="title">' +
				item.title +
				'</div></div>'
		};

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
			i = 0;

			for(; i < l; i++) {
				sectionsList[i].insertAdjacentHTML('beforebegin', template(items[i]));
			}

			sloth( {
				on: document.querySelectorAll( '.related-article .lazy' ),
				threshold: 400,
				callback: lazyload
			} );
	});
});
