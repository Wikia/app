/*
 * @define sections
 * module used to handle sections on wikiamobile
 * expanding and collapsing
 *
 * @author Jakub Olek
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */


define('sections', ['JSMessages', 'jquery'], function(msg, $){
	var d = document,
		fragment = d.createDocumentFragment(),
		OPENCLASS = 'open',
		goBck = '<span class=goBck>&uarr; ' + msg('wikiamobile-hide-section') + '</span>',
		chevron = '<span class=chev></span>',
		$d = $(d);

	function init(){
		var article = d.getElementById('mw-content-text');

		//avoid running if there are no sections which are direct children of the article section
		if(d.querySelector('#mw-content-text > h2')){
			var contents = article.childNodes,
				root = fragment,
				x,
				y = contents.length,
				currentSection = false,
				node,
				nodeName,
				isH2;

			for (x=0; x < y; x++) {
				node = $(contents[x]);
				nodeName = node[0].nodeName;
				isH2 = (nodeName == 'H2');

				if (nodeName != '#comment' && nodeName != 'SCRIPT') {
					if(node[0].id == 'WkMainCntFtr' || node[0].className == 'printfooter' || node.hasClass('noWrap')){
						//do not wrap these elements
						root = fragment;
					}else if (isH2){
						node = node
							.clone(true)
							.addClass('collSec')
							//append chevron
							.append(chevron);

						fragment.appendChild(node[0]);

						currentSection = $(d.createElement('section')).addClass('artSec').attr('data-index', x)[0];
						fragment.appendChild(currentSection);

						root = currentSection;
						continue;
					}

					root.appendChild(node.clone(true)[0]);
				}
			}

			article.innerHTML = '';
			article.appendChild( fragment );
		}

		//this has to run even if we don't find any sections on a page for ie. Category Pages, pages without any sections but with readmore and stuff
		$('#wkPage').on('click', '.collSec', function(){
			toggle(this);
		}).on('click', '.goBck', function(){
			var parent = $(this.parentElement);

			parent.removeClass(OPENCLASS).prev().removeClass(OPENCLASS)[0].scrollIntoView();

			$d.trigger('sections:close', [parent]);
		});
	}

	function toggle(h2, scroll){
		h2 = $(typeof h2 === 'string' ? document.getElementById(h2) : h2);

		if(h2.length){
			if(h2.hasClass(OPENCLASS)){
				close(h2);
			}else{
				open(h2, scroll);
			}
		}
	}

	function find(heading){
		var h2;

		if(typeof heading == 'string') {
			heading = $(d.getElementById(heading.replace(/ /g, '_')));
		}

		//find in what section is the header
		if(heading.length && !heading.is('h1,h2')) h2 = heading.parent('.artSec').prev();

		return [h2 || $(heading), heading];
	}

	function scrollTo(header){
		var top =  header.offset().top;
		//scroll header into view
		//if the page is long that is the way I found it reliable
		//without calling it like that
		//android sometimes did not scroll at all
		//and iOS sometimes scrolled to a wrong place
		window.scrollTo(0, top);
		setTimeout(function(){
			window.scrollTo(0, top);
		}, 50);
	}

	function open(id, scroll) {
		var headers = find(id),
			h2 = headers[0];

		if(!h2.hasClass(OPENCLASS)) {
			var next = h2.addClass(OPENCLASS).next().addClass(OPENCLASS);

			if(!h2[0].goBackAdded && next.hasClass('artSec')) {
				next.append(goBck);
				h2[0].goBackAdded = true;
			}

			$.event.trigger('sections:open', [next]);
		}

		if(scroll && headers[1]){
			scrollTo(headers[1]);
		}
	}

	function close(id) {
		var h2 = find(id)[0],
			next;

		if(h2.hasClass('open')) {
			next = h2.removeClass(OPENCLASS).next().removeClass(OPENCLASS);

			$.event.trigger('sections:close', [next]);
		}
	}

	return {
		init: init,
		toggle: toggle,
		open: open,
		close: close
	};
});
