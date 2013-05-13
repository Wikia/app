(function(html, window){
	var links = document.querySelectorAll('a:not(.external):not(.extiw)'),
		host = window.wgServer.replace(/^http\:\/\//, ''),
		i = links.length,
		namespaces = window.wgNamespaceIds,
		regExpNamespace = new RegExp(window.wgArticlePath.replace('$1', "([^:]*)")),
		//not all namespaces in GG should be clickable
		//there are custom namespaces on wikis therefore black list will be better suited here
		disabledNs = [-2,-1,1,2,3,4,5,6,7,10,11,12,13,15,110,111,500,501,700,701,1200,1201,1202],
		link,
		path,
		parent,
		notAllowed,
		namespace,
		pathMatch;

	while(i--) {
		link = links[i];
		path = link.pathname;
		parent = link.parentElement;
		notAllowed = ((link.host && link.host !== host) || path === '/wikia.php') && !~parent.className.indexOf('thumb');

		if(!notAllowed && ~path.indexOf(':')) {
			pathMatch = path.match(regExpNamespace);

			if(pathMatch && (namespace = namespaces[pathMatch[1].toLowerCase()])) {
				notAllowed = !!~disabledNs.indexOf(namespace);
			}
		}

		if(notAllowed) {
			if(~link.className.indexOf('image')) {
				parent.className = 'thumb';
				link.firstElementChild.className += ' media';
			}else {
				link.className += ' disabled';
			}
		}
	}

	//handling clicking on a link
	html.addEventListener('click', function(ev){
		var t = ev.target,
			title,
			ns = 0;

		if(t.tagName === 'A'){
			ev.preventDefault();

			if(t.hasAttribute('title')) {
				title = t.title.replace(/ /g, '_');
			}else{
				//links in ie. images do not have title attribute
				title = t.pathname.replace("/wiki/", '')
			}

			if(~title.indexOf(':')) {
				var split = title.split(':'),
					namespace = namespaces[split.shift().toLowerCase()];

				if(namespace) {
					title = split.join(':');
					ns = namespace;
				}
			}

			Ponto.invoke(
				'Linker',
				'goTo',
				{
					title: decodeURIComponent(title),
					ns: ns
				}
			);
		}
	});

	//handling grabing all photos on a page;
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

	window.Photos = Photos;

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
			return toggle('serif', 'sans-serif', type);
		};

		this.setSize = function(size){
			size = Math.max(Math.min(~~size, 200), 50);
			html.style.fontSize = size + '%';

			return size;
		};

		this.toggleAlignment = function(alignment){
			return toggle('full', 'left', alignment)
		};

		this.setOptions = function(options){
			options = options || {};

			return {
				size: options.size !== undefined && this.setSize(options.size),
				type: options.type !== undefined && this.toggleType(options.type),
				alignment: options.alignment !== undefined && this.toggleAlignment(options.alignment)
			};

		};
	}

	Ponto.PontoBaseHandler.derive(Font);

	Font.getInstance = function(){
		return new Font();
	};

	window.Font = Font;

	require(['modal', 'sections'], function(modal, sections){
		function Modal(){
			this.close = function(){
				var open = modal.isOpen();

				modal.close();

				return !!open;
			};
		}

		Ponto.PontoBaseHandler.derive(Modal);

		Modal.getInstance = function(){
			return new Modal();
		};

		window.Modal = Modal;

		function Sections(){
			this.open = function(id){
				sections.open(id, true);
			};
			this.close = sections.close;
			this.toggle = function(id) {
				sections.toggle(id, true);
			};
		}

		Ponto.PontoBaseHandler.derive(Sections);

		Sections.getInstance = function(){
			return new Sections();
		};

		window.Sections = Sections;

		sections.addEventListener('open', function(){
			document.documentElement.style.minHeight = document.documentElement.offsetHeight + 'px';
		});

		sections.addEventListener('close', function(){
			document.documentElement.style.minHeight = 0;
		});
	});

	window.addEventListener('DOMContentLoaded', function(){
		require(['toc'], function(toc){
			Ponto.invoke(
				'Article',
				'data',
				{
					data: {
						title: window.wgTitle,
						articleId: window.wgArticleId,
						cityId: window.wgCityId
					},
					toc: toc.get()
				}
			);
		});
	});
})(document.documentElement, window);