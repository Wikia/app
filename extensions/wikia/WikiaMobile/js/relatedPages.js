require( [ 'wikia.window', 'wikia.nirvana' ], function( window, nirvana ) {
	var sectionsList = window.document.querySelectorAll('#mw-content-text h2[id]:not(:first-of-type):not(:last-of-type)' ),
		sectionsLength = sectionsList.length,
		articleId = window.wgArticleId;

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
				sectionsList[i].insertAdjacentHTML('beforebegin', '<div>' + items[i].title + '</div>');
			}
	});
});
