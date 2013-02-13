/**
 * Article Comments initialization for the WikiaMobile skin
 * This is loaded on any page that supports commenting and will load the full ArticleComments
 * functionality on-demand
 *
 * @author Jakub 'Student' Olek
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 **/

require(['throbber', 'wikia.querystring', 'wikia.loader', 'wikia.nirvana'], function(throbber, qs, loader, nirvana){
	var hash = qs().getHash(),
		wkArtCom,
		collSec,
		open,
		wkComm,
		commentsHTML,
		styles,
		scripts,
		clickEvent = 'click',
		responseCounter = 0;

	if(hash.indexOf('comm-') > -1){
		open = hash.slice(5);
	}

	//TODO: refactor when Deferreds will be pulled in in the mobile skin code
	function show(){
		if(++responseCounter >= 2){
			throbber.remove(wkArtCom);

			loader.processStyle(styles);
			wkComm.insertAdjacentHTML('beforeend', commentsHTML);
			loader.processScript(scripts);

			if(open){
				var elm = document.getElementById(open);
				if(elm){
					setTimeout(function(){
						elm.scrollIntoView();
					}, 500);
					if(elm.nodeName == 'LI'){
						setTimeout(function(){
							var evObj = document.createEvent('MouseEvents');
							evObj.initMouseEvent(clickEvent, true, true, window);
							elm.getElementsByClassName('cmnRpl')[0].dispatchEvent(evObj);
						}, 1500);
					}
				}
			}

			//unused now, clear them up :)
			commentsHTML = styles = scripts = responseCounter = null;

			collSec.removeEventListener(clickEvent, init, true);
		}
	}

	function init(){
		throbber.show(wkArtCom, {center: true, size:'40px'});

		nirvana.sendRequest({
			controller: 'ArticleComments',
			method: 'WikiaMobileCommentsPage',
			data: {
				articleID: wgArticleId,
				page: 1
			},
			format: 'html',
			type: 'GET'
		}).done(
			function(res){
				commentsHTML = res;
				show();
			}
		);

		loader({
			type: loader.MULTI,
			resources: {
				styles: '/extensions/wikia/ArticleComments/css/ArticleComments.wikiamobile.scss',
				messages: 'WikiaMobileComments',
				scripts: 'articlecomments_js_wikiamobile',
				params: {
					uselang: wgUserLanguage//ensure per-language Varnish cache
				}
			}
		}).done(
			function(res){
				styles = res.styles;
				scripts = res.scripts.join('');
				show();
			}
		);
	}

	Wikia(function(){
		wkArtCom = document.getElementById('wkArtCom');
		collSec = wkArtCom.getElementsByClassName('collSec')[0];
		wkComm = document.getElementById('wkComm');

		if(open){
			init();
			collSec.className += ' open';
			wkComm.className += ' open';
		}else{
			collSec.addEventListener(clickEvent, init, true);
		}
	});
});