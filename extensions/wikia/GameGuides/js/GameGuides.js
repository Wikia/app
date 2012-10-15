(function(html, w){
	//handling clicking on a link
	html.addEventListener('click', function(ev){
		var t = ev.target;

		if(t.tagName === 'A') {
			ev.preventDefault();
			Ponto.invoke(
				'Linker',
				'goTo',
				{
					title: t.title.replace(/ /g, '_')
				}
			);
		}
	}, true);

	//handling grabing all links on a page;
	function Photos(){
		this.getList = function(){
			var images = Array.prototype.slice.call(document.images),
				links = [];

			for(var i = 0, l = images.length; i < l; i++){
				links[i] = images[i].getAttribute('data-src') || images[i].src;
			}

			return JSON.stringify(links);
		};
	}

	Ponto.PontoBaseHandler.derive(Photos);

	Photos.getInstance = function(){
		return new Photos();
	};

	w.Photos = Photos;

	w.changeFontType = function(){
		if(html.className.indexOf('serif') > -1) {
			html.className = html.className.replace(' serif', '');
		}else{
			html.className += ' serif';
		}
	};

	w.setFontSize = function(size){
		html.style.fontSize = Math.max(Math.min(~~size, 200), 50) + '%';
	};

	$(function(){
//		require(['toc'], function(toc){
//			Ponto.invoke(
//				'Article',
//				'data',
//				{
//					data: {
//						title: wgTitle,
//						articleId: wgArticleId
//					},
//					toc: toc.getList()
//				}
//			);
//		});
	});
})(document.documentElement, this);

