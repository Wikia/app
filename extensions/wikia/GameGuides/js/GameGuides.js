(function(html, w){
	//handling clicking on a link
	html.addEventListener('click', function(ev){
		var t = ev.target;

		if(t.tagName === 'A' && t.hasAttribute('title')) {
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

	function toggle(on, off, force){
		var hasClass = ~html.className.indexOf(on);

		if(!force || force == on || force == off){
			if(force == off || hasClass && force != on) {
				hasClass && (html.className = html.className.replace(' ' + on, ''));

				return off;
			}else{
				!hasClass && (html.className += ' ' + on);

				return on;
			}
		}
	}

	function Font(){
		this.toggleType = function(type){
			return toggle('serif', 'sans-serif', type)
		};

		this.setSize = function(size){
			size = Math.max(Math.min(~~size, 200), 50);
			html.style.fontSize = size + '%';

			return size;
		};

		this.toggleAlignment = function(alignment){
			return toggle('full', 'left', alignment)
		};

		this.setOptions = function(size, type, alignment){
			return {
				size: size !== undefined && this.setSize(size),
				type: type && this.toggleType(type),
				alignment: alignment && this.toggleAlignment(alignment)
			};

		};
	}

	Ponto.PontoBaseHandler.derive(Font);

	Font.getInstance = function(){
		return new Font();
	};

	w.Font = Font;

	require(['sections'], function(s){
		function Sections(){
			this.open = function(id){
				s.open(id, true);
			}
			this.close = s.close;
			this.toggle = function(id) {
				s.toggle(id, true);
			}
		}

		Ponto.PontoBaseHandler.derive(Sections);

		Sections.getInstance = function(){
			return new Sections();
		};

		w.Sections = Sections;
	});


	window.addEventListener('DOMContentLoaded', function(){
		require(['toc'], function(toc){
			Ponto.invoke(
				'Article',
				'data',
				{
					data: {
						title: wgTitle,
						articleId: wgArticleId,
						cityId: wgCityId
					},
					toc: toc.get()
				}
			);
		});
	});
})(document.documentElement, this);