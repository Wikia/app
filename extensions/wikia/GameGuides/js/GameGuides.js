(function(html, w){
	var server = new RegExp(wgServer + '/(wiki\/)?', 'i');

	//handling clicking on a link
	html.addEventListener('click', function(ev){
		var t = ev.target;

		if(t.tagName == 'A') {
			ev.preventDefault();
			Ponto.invoke(
				'Linker',
				'goTo',
				{
					link: t.href.replace(server, '')
				}
			);
		}
	});

	//handling grabing all links on a page;
	function Photos(){
		this.getList = function(){
			require(['media'], function(m){
				var images = m.getImages(),
					links = [];

				for(var i = 0, l = images.length; i < l; i++){
					links[i] = images[i].url;
				}

				return links;
			});
		};
	}

	Ponto.PontoBaseHandler.derive(Photos);

	Photos.getInstance = function(){
		return new Photos();
	};

	window.Photos = Photos;

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
		var	links = Array.prototype.slice.call(document.getElementsByTagName('a')),
			l = links.length,
			link;

		while(link = links[l--]){
			if(link.href.match(server)) {
				link.className += ' validLink';
			}
		}

		require(['toc'], function(toc){
			Ponto.invoke(
				'Article',
				'date',
				{
					data: {

					},
					toc: toc.getList()
				}
			);
		});
	});
})(document.documentElement, this);

