require(['sloth', 'wikia.nirvana', 'wikia.window', 'wikia.loader', 'wikia.mustache'], function(sloth, nirvana, w, loader, mustache){
	'use strict';

	var relatedPages = $('#wkRelPag');

	if(relatedPages.length > 0) {
		var element  = $('#wkMainCntFtr')[0]; // sloth don't accept jQuery objects
		if(!element) {
			element = $('#wkRelPag')[0]; // sloth don't accept jQuery objects
		}

		sloth({
			on: element,
			threshold: 100,
			callback: function() {

				$.when(
					nirvana.getJson(
						'RelatedPagesApi',
						'getList',
						{
							ids: w.wgArticleId
						}
					),
					loader({
						type: loader.MULTI,
						resources: {
							mustache: 'extensions/wikia/RelatedPages/templates/RelatedPages_item.mustache'
						}

					})
				).done(
					function(data, resources) {

						var items = data[0].items,
							pages = items && items[w.wgArticleId],
							mustacheData = {
								imgWidth: (w.skin === 'mobile' ? 100 : 200),
								imgHeight: (w.skin === 'mobile' ? 50 : 100)
						},
							artImgPlaceholder = (w.skin === 'mobile' ? w.wgCdnRootUrl + '/extensions/wikia/WikiaMobile/images/read_placeholder.png' : '');


						console.log(pages);

						if (pages && pages.length) {
							var page,
								ul = relatedPages.children('ul'),
								lis = '',
								i = 0;

							while(page = pages[i++]) {

								mustacheData.pageUrl = page.url;
								mustacheData.pageTitle = page.title;
								mustacheData.imgUrl = (page.imgUrl ? page.imgUrl : artImgPlaceholder);
								mustacheData.artSnippet = page.text;

								lis += mustache.render(resources.mustache[0], mustacheData);
							}

							ul.append(lis);

							if (w.skin === 'mobile') {
								relatedPages.addClass('show');
							}
						}
					}
				);
			}
		});
	}
});
