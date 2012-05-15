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
		article = d.getElementById('wkMainCnt'),
		page = d.getElementById('wkPage'),
		click = ev.click;

	function init(){
		//avoid running if there are no sections which are direct children of the article section
		if(d.querySelector('#wkMainCnt > h2')){
			var contents = article.childNodes,
				wrapper = article.cloneNode(false),
				root = wrapper,
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
						root = wrapper;
					}else if (isH2){
						if (currentSection) {
							currentSection.insertAdjacentHTML('beforeend', goBck);
							wrapper.appendChild(currentSection);
						}

						currentSection = d.createElement('section');
						currentSection.className = 'artSec';
						node = node.cloneNode(true);

						node.className += ' collSec';

						wrapper.appendChild(node);
						wrapper.appendChild(currentSection);
						root = currentSection;
						continue;
					}
					root.appendChild(node.cloneNode(true));
				}
			}

			page.removeChild(article);
			//insertAdjacentHTML does not parse scripts that may be inside sections
			page.insertAdjacentHTML('beforeend', wrapper.outerHTML);
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
		})
		.on(click, '.goBck', function(){
			var parent = this.parentElement,
				prev = parent.previousElementSibling;

			parent.className = parent.className.replace(' open', '');
			prev.className = prev.className.replace(' open' , '');
			prev.scrollIntoView();
		});
	}

	return {
		init: init
	}
})