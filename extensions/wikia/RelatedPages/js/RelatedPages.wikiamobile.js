require(['sloth', 'wikia.nirvana', 'wikia.window'], function(sloth, nirvana, w){
	'use strict';

	var relatedPages = document.getElementById('wkRelPag');

	if(relatedPages) {
		sloth({
			on: document.getElementById('wkMainCntFtr'),
			threshold: 100,
			callback: function(){
				nirvana.getJson(
					'RelatedPagesApi',
					'getList',
					{
						ids: w.wgArticleId
					}
				).done(
					function(data){
						var pages = data.items && data.items[w.wgArticleId];

						if(pages && pages.length){
							var page,
								ul = relatedPages.getElementsByTagName('ul')[0],
								lis = '',
								i = 0;

							while(page = pages[i++]) {
								lis += '<li><a href="' +
									page.url +
									'"><img width=100 height=50 src="' +
									(page.imgUrl ? page.imgUrl : w.wgCdnRootUrl + '/extensions/wikia/WikiaMobile/images/read_placeholder.png') +
									'"/> ' +
									page.title +
									'</a></li>';
							}

							ul.innerHTML = lis;
							relatedPages.className += ' show';
						}
					}
				);
			}
		});
	}
});