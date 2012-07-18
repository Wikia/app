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
		page = d.getElementById('wkMainCnt'),
		fragment = d.createDocumentFragment();
		click = ev.click,
		callbacks = {
			open: [],
			close: []
		};

		function fireEvent(event, target){
			var stack = callbacks[event];
			len = stack.length;

			if(len > 0){
				setTimeout(function(){
					var x = 0;

					for(; x < len; x++){
						stack[x].call(target);
					}
				}, 0);
			}
		}

	function init(){
		//avoid running if there are no sections which are direct children of the article section
		if(d.querySelector('#mw-content-text > h2')){
			var contents = article.childNodes,
				root = fragment,
				x,
				y = contents.length,
				currentSection,
				node,
				nodeName,
				isH2,
				goBck = '<span class=goBck>&uarr; '+$.msg('wikiamobile-hide-section')+'</span>';

			for (x=0; x < y; x++) {
				node = contents[x];
				nodeName = node.nodeName;
				isH2 = (nodeName == 'H2');

				if (nodeName != '#comment' && nodeName != 'SCRIPT') {
					if(node.id == 'WkMainCntFtr' || node.className == 'printfooter' || (node.className && node.className.indexOf('noWrap') > -1)){
						//do not wrap these elements
						currentSection.insertAdjacentHTML('beforeend', goBck);
						root = fragment;
					}else if (isH2){
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
		}
		//this has to run even if we don't find any sections on a page for ie. Category Pages, pages without any sections but with readmore and stuff
		$(d.body).on(click, '.collSec', function(){
			var isOpen = (this.className.indexOf('open') > -1),
				next = this.nextElementSibling;

			track(['section', isOpen ? 'close' : 'open']);

			if(isOpen){
				this.className = this.className.replace(' open', '');
				next.className = next.className.replace(' open', '');
			}else{
				this.className += ' open';
				next.className += ' open';
			}

			 fireEvent((isOpen) ? 'close' : 'open', next);
		}).on(click, '.goBck', function(){
			var parent = this.parentElement,
				prev = parent.previousElementSibling;

			track('section/close');

			parent.className = parent.className.replace(' open', '');
			prev.className = prev.className.replace(' open', '');
			next.className = next.className.replace(' open', '');
			fireEvent('close', parent);
			prev.scrollIntoView();
		});
	}

	return {
		init: init,
		addEventListener: function(event, callback){
			if(callbacks[event]){
				callbacks[event].push(callback);
			}
		},
		removeEventListener: function(event, callback){
			if(callbacks[event]){
				var stack = callbacks[event],
					len = stack.lenght;

				while(len--){
					if(stack[len] === callback){
						stack.splice(len, 1);
						return;
					}
				}
			}
		}
	}
})