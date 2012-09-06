/*
 * @define sections
 * module used to handle sections on wikiamobile
 * expanding and collapsing
 *
 * @author Jakub Olek
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

define('sections', ['events', 'track'], function(ev, track){
	var d = document,
		article = d.getElementById('mw-content-text'),
		fragment = d.createDocumentFragment(),
		click = ev.click,
		callbacks = {
			open: [],
			close: []
		},
		OPENCLASS = ' open';

	function fireEvent(event, target){
		var stack = callbacks[event],
			len = stack.length;

		if(len > 0){
			setTimeout(function(){
				var x = 0;

				while(x < len){
					stack[x++].call(target);
				}
			}, 0);
		}
	}

	//add class noSect to images outside sections
	function addNoSectClass(parent){
		if(parent){
			//documentFragment has no support for getElementsByClassName
			var images = parent.querySelectorAll('.lazy'),
				i = 0,
				elm;

			while(elm = images[i++]) elm.className += ' noSect';
		}
	}

	function init(){
		//avoid running if there are no sections which are direct children of the article section
		if(d.querySelector('#mw-content-text > h2')){
			var contents = article.childNodes,
				root = fragment,
				x,
				y = contents.length,
				currentSection = false,
				node,
				nodeName,
				isH2,
				addNoSect = true,
				goBck = '<span class=goBck>&uarr; ' + $.msg('wikiamobile-hide-section') + '</span>';

			for (x=0; x < y; x++) {
				node = contents[x];
				nodeName = node.nodeName;
				isH2 = (nodeName == 'H2');

				if (nodeName != '#comment' && nodeName != 'SCRIPT') {
					if(node.id == 'WkMainCntFtr' || node.className == 'printfooter' || (node.className && node.className.indexOf('noWrap') > -1)){
						//do not wrap these elements
						currentSection && currentSection.insertAdjacentHTML('beforeend', goBck);
						root = fragment;
					}else if (isH2){

						if(addNoSect){
							addNoSectClass(fragment);
							addNoSect = false;
						}

						if (currentSection) {
							currentSection.insertAdjacentHTML('beforeend', goBck);
							fragment.appendChild(currentSection);
						}

						currentSection = d.createElement('section');
						currentSection.className = 'artSec';
						currentSection.setAttribute('data-index', x);
						node = node.cloneNode(true);

						node.className += ' collSec';

						//append chevron
						node.insertAdjacentHTML('beforeend', '<span class=chev></span>');
						fragment.appendChild(node);
						fragment.appendChild(currentSection);
						root = currentSection;
						continue;
					}

					root.appendChild(node.cloneNode(true));
				}
			}

			article.innerHTML = '';
			article.appendChild( fragment );
		}else if(article){//check if the node exists, since sometimes it doesn't (Example: User Profile Pages)
			addNoSectClass(article);
		}

		//this has to run even if we don't find any sections on a page for ie. Category Pages, pages without any sections but with readmore and stuff
		d.body.addEventListener(click, function(ev){
			var t = ev.target;
			if(t.className.indexOf('collSec') > -1){
				toggle(t);
			}else if(t.className.indexOf('goBck') > -1){
				var parent = t.parentElement,
					prev = parent.previousElementSibling;

				track('section/close');

				parent.className = parent.className.replace(' open', '');
				prev.className = prev.className.replace(' open', '');
				fireEvent('close', parent);
				prev.scrollIntoView();
			}
		});
	}

	function toggle(h2){
		if(h2 && isOpen(h2)){
			close(h2);
		}else{
			open(h2)
		}
	}

	function open(h2) {
		if(h2 && !isOpen(h2)) {
			var next = h2.nextElementSibling;

			h2.className += OPENCLASS;
			next.className += OPENCLASS;

			fireEvent('open', next);
			track(['section', 'open']);
		}
	}

	function close(h2) {
		if(h2 && isOpen(h2)) {
			var next = h2.nextElementSibling;

			h2.className = h2.className.replace(OPENCLASS, '');
			next.className = next.className.replace(OPENCLASS, '');

			fireEvent('close', next)
			track(['section', 'close']);
		}
	}

	function isOpen(h2){
		return (h2.className.indexOf('open') > -1);
	}

	return {
		init: init,
		toggle: toggle,
		open: open,
		close: close,
		addEventListener: function(event, callback){
			callbacks[event] && callbacks[event].push(callback);
		},
		removeEventListener: function (event, callback) {
			var stack = callbacks[event],
				len;

			if (stack instanceof Array) {
				len = stack.length;

				while (len > 0) {
					len -= 1;

					if (stack[len] === callback) {
						stack.splice(len, 1);
						break;
					}
				}
			}
		}
	}
});
