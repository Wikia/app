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

				//if anchor was clicked dont trigger tracking event of close
				(table.className.indexOf('open') > -1 ? close : open)(a);

				if(a){
					track.event('toc', track.CLICK, {label: 'element'});

					sections.open(node.getAttribute('href').substr(1), true);
				}
			}, true);
		}
	}

	function getToc(list) {
		var toc = [],
			section,
			a,
			id,
			ul,
			parent,
			text;

		for(var i = 0, l = list.length; i < l; i++){
			section = list[i];
			a = section.children[0];
			id = a.hash.slice(1);
			ul = section.children[1];
			text = a.getElementsByClassName('toctext')[0];

			parent = {
				id: id,
				name: text.textContent || text.innerText
			};

			ul && (parent.children = getToc(ul.children));

			toc.push(parent);
		}

		return toc;
	}

	return {
		init: init,
		open: open,
		close: close,
		get: function(){
			var toc = [];

			if(table || (table = d.getElementById('toc'))){
				toc = getToc(table.getElementsByClassName('toclevel-1'));
			}else{
				//fallback if there is no toc on a page
				var h2s = d.querySelectorAll('#mw-content-text h2[id]'),
					h2,
					i = 0;

				while(h2 = h2s[i++]){
					toc.push({
						id: h2.id,
						name: h2.textContent || h2.innerText
					})
				}
			}

			return toc;
		}
	};
});