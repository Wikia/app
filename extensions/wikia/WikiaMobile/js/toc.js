/*global WikiaMobile*/

//init toc

define('toc', ['track', 'events'], function toc(track, events){
	//private
	var d = document,
		table,
		conStyle,
		click = events.click;

	function open(a){
		if(table){
			table.className += ' open';
			d.body.className += ' hidden';
			track('/toc/open');
			conStyle.minHeight = (table.offsetHeight - 40) + 'px';
		}
	}

	function close(a){
		if(table){
			table.className = table.className.replace(' open', '');
			d.body.className =  d.body.className.replace(' hidden', '');
			if(!a) track('/toc/close');
			conStyle.minHeight = '0';
		}
	}

	function init(){
		//init only if toc is on a page
		table = d.getElementById('toc');

		if(table){
			d.getElementById('toctitle').insertAdjacentHTML('afterbegin', '<span class=chev></span>');
			d.body.className += ' hasToc';
			conStyle = d.getElementById('wkMainCnt').style;

			table.addEventListener(click, function(ev){
				ev.preventDefault();

				var node = ev.target.parentNode,
					a = (node.nodeName == 'A');

				(table.className.indexOf('open') > -1) ? close(a) : open(a);

				if(a){
					track('/toc/go');

					var elm = d.getElementById(node.getAttribute('href').substr(1)),
						h2 = elm;

					//find in what section is the header
					while(h2.nodeName != 'H2'){
						h2 = (elm.parentNode.className.indexOf('artSec') > -1) ? h2.parentNode.previousElementSibling : h2.parentNode;
					}

					//open section if necessarry
					if(h2.className.indexOf('open') == -1){
						h2.className += ' open';
						h2.nextElementSibling.className += ' open';
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
			});
		}
	}

	return {
		init: init,
		open: open,
		close: close
	}
});