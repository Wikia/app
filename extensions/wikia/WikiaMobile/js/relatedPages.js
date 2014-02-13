require( [ 'wikia.window', 'wikia.nirvana', 'jquery', 'wikia.thumbnailer', 'lazyload', 'sloth' ], function( window, nirvana, $, thumbnailer, lazyload, sloth ) {
	var sectionsList = $.makeArray(
			window.document.querySelectorAll('#mw-content-text h2[id]:not(:first-of-type):not(:last-of-type)' )
		).filter( function( section ){
			//TODO: Filter sections shorter than 1000px
			return true;
		} ),
		sectionsLength = sectionsList.length,
		articleId = window.wgArticleId,
		header = 'Related Article',
		template = function(item){
			return '<a href="'+ item.url +'" class="related-article"><div class="header">' +
				header +
				'</div><img class="lazy link" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="' +
				(item.imgUrl ? thumbnailer.getThumbURL(item.imgUrl, 'image', 280, 158) : '!!!') +
				'" width="280px" height="158px"><div class="title">' +
				item.title +
				'</div></div>'
		};

	nirvana.getJson(
		'RelatedPagesApi',
		'getList',
		{
			ids: [ articleId ],
			limit: sectionsLength
		}
	).done( function( data ){
		var items = data.items[articleId],
			l = Math.min( sectionsLength, items.length ),
			i = 0;
			console.log(items);
			console.log(l);
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
