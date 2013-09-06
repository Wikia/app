require(['sloth', 'wikia.nirvana', 'wikia.window', 'wikia.loader', 'wikia.mustache'], function(sloth, nirvana, w, loader, mustache){
	'use strict';

	var relatedPages = $('#wkRelPag'),
		isMobileSkin = (w.skin === 'wikiamobile' ? true : false);

	if( relatedPages.length > 0 ) {
		var element = $('#wkRelPagHead')[0], // sloth don't accept jQuery objects
			controller = 'RelatedPagesApi',
			method = 'getList';

		sloth({
			on: element,
			threshold: 100,
			callback: function() {
				loader({
					type: loader.MULTI,
					resources: {
						mustache: 'extensions/wikia/RelatedPages/templates/RelatedPages_item.mustache',
						templates: [{
							controller: controller,
							method: method,
							params: {
								ids: w.wgArticleId
							}
						}]
					}
				}).done(
					function(data) {
						var items = JSON.parse(data.templates[controller + '_' + method]).items,
							pages = items && items[w.wgArticleId],
							mustacheData = {
								imgWidth: (isMobileSkin ? 100 : 200),
								imgHeight: (isMobileSkin ? 50 : 100)
							},
							artImgPlaceholder = (isMobileSkin ? w.wgCdnRootUrl + '/extensions/wikia/WikiaMobile/images/read_placeholder.png' : '');

						if( pages && pages.length ) {
							var page,
								ul = relatedPages.children('ul'),
								lis = '',
								i = 0;

							while( page = pages[i++] ) {
								mustacheData.pageUrl = page.url;
								mustacheData.pageTitle = page.title;
								mustacheData.imgUrl = ( page.imgUrl ? page.imgUrl : artImgPlaceholder );
								mustacheData.artSnippet = page.text;

								lis += mustache.render( data.mustache[0], mustacheData );
							}

							ul.append(lis);

							if( isMobileSkin ) {
								relatedPages.addClass('show');
							}
						}
					}
				);
			}
		});
	}
});
