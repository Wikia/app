/*global WikiaMobile*/

//init toc

define('toc', ['track', 'sections', 'wikia.window', 'jquery'], function toc(track, sections, w, $){
	//private
	var d = w.document,
		$body = $(d.body),
		table,
		conStyle;

	function open(){
		if(table.length){
			table.addClass('open');
			$body.addClass('hidden');
			track.event('toc', track.CLICK, {label: 'open'});
			conStyle.minHeight = (table.height() - 40) + 'px';
		}
	}

	function close(a){
		if(table.length && table.hasClass('open')){
			table.removeClass('open');
			$body.removeClass('hidden');
			if(!a) {track.event('toc', track.CLICK, {label: 'close'});}
			conStyle.minHeight = '0';
		}
	}

	function init(){
		//init only if toc is on a page
		table = $(d.getElementById('toc'));

		if(table.length){
			d.getElementById('toctitle').insertAdjacentHTML('afterbegin', '<span class=chev></span>');
			$body.addClass('hasToc');
			conStyle = d.getElementById('mw-content-text').style;

			table.on('click', function(event){
				event.preventDefault();

				var	target = event.target,
					a = (target.nodeName == 'A');

				//if anchor was clicked dont trigger tracking event of close
				(table.hasClass('open') ? close : open)(a);

				if(a){
					track.event('toc', track.CLICK, {label: 'element'});

					sections.open(target.getAttribute('href').substr(1), true);
				}
			});
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
				name: (text.textContent || text.innerText).trim()
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

			if(table.length || (table = $(d.getElementById('toc')))){
				toc = getToc(table.find('.toclevel-1'));
			}else{
				//fallback if there is no toc on a page
				var h2s = d.querySelectorAll('#mw-content-text h2[id]'),
					h2,
					i = 0;

				while(h2 = h2s[i++]){
					toc.push({
						id: h2.id,
						name: (h2.textContent || h2.innerText).trim()
					})
				}
			}

			return toc;
		}
	};
});