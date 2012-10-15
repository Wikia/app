/*global WikiaMobile*/

//init toc

define('toc', ['track', 'sections'], function toc(track, sections){
	//private
	var d = document,
		table,
		conStyle;

	function open(){
		if(table){
			table.className += ' open';
			d.body.className += ' hidden';
			track.event('toc', track.CLICK, {label: 'open'});
			conStyle.minHeight = (table.offsetHeight - 40) + 'px';
		}
	}

	function close(a){
		if(table && table.className.indexOf('open') > -1){
			table.className = table.className.replace(' open', '');
			d.body.className =  d.body.className.replace(' hidden', '');
			if(!a) {track.event('toc', track.CLICK, {label: 'close'});}
			conStyle.minHeight = '0';
		}
	}

	function init(){
		//init only if toc is on a page
		table = d.getElementById('toc');

		if(table){
			d.getElementById('toctitle').insertAdjacentHTML('afterbegin', '<span class=chev></span>');
			d.body.className += ' hasToc';
			conStyle = d.getElementById('mw-content-text').style;

			table.addEventListener('click', function(ev){
				ev.preventDefault();

				var node = ev.target,
					a = (node.nodeName == 'A');

				(table.className.indexOf('open') > -1 ? close : open)(a);

				if(a){
					track.event('toc', track.CLICK, {label: 'element'});

					var elm = d.getElementById(node.getAttribute('href').substr(1)),
						h2 = elm;

					//find in what section is the header
					while(h2.nodeName != 'H2'){
						h2 = (elm.parentNode.className.indexOf('artSec') > -1) ? h2.parentNode.previousElementSibling : h2.parentNode;
					}

					//open section if necessarry
					if(h2.className.indexOf('open') == -1){
						sections.toggle(h2);
					}

					//scroll header into view
					//if the page is long that is the way I found it reliable
					//without calling it like that android sometimes did not scroll at all
					//and iOS sometimes scrolled to a wrong place
					elm.scrollIntoView();
					setTimeout(function(){
						elm.scrollIntoView();
					}, 50);
				}
			}, true);
		}
	}

	function getToc(list) {
		var toc = [],
			section,
			link,
			ul,
			parent;

		for(var i = 0, l = list.length; i < l; i++){
			section = list[i];
			link = section.children[0].href;
			ul = section.children[1];
			parent = { section: link.slice(link.indexOf('#') + 1) };

			ul && (parent.children = getToc(ul.children));

			toc.push(parent);
		}

		return toc;
	}

	function getList(){
		var toc = [];

		if(table || (table = d.getElementById('toc'))){
			toc = getToc(table.getElementsByClassName('toclevel-1'));
		}

		return toc;
	}

	return {
		init: init,
		open: open,
		close: close,
		getList: getList
	};
});