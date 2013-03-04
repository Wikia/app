require(['sloth', 'wikia.nirvana', 'wikia.window'], function(sloth, nirvana, w){
	var relatedContent = document.getElementById('wkRltdCnt');

	if(relatedContent) {
		sloth({
			on: relatedContent,
			threshold: 50,
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
								parent = document.getElementById('wkRelPag'),
								ul = parent.getElementsByTagName('ul')[0],
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
							parent.className += ' show';
						}
					}
				)
			}
		})
	}
});