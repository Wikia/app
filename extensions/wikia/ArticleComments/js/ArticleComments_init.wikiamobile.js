/**
 * Article Comments initialization for the WikiaMobile skin
 * This is loaded on any page that supports commenting and will load the full ArticleComments
 * functionality on-demand
 *
 * @author Jakub 'Student' Olek
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 **/

require(['loader', 'querystring', 'events'], function(loader, qs, events){
	var hash = (new qs()).getHash(),
		wkArtCom,
		collSec,
		open,
		wkComm,
		commentsHTML,
		styles,
		scripts,
		clickEvent = events.click,
		responseCounter = 0;

	if(hash.indexOf('comm-') > -1){
		open = hash.slice(5);
	}

	//TODO: refactor when Deferreds will be pulled in in the mobile skin code
	function show(){
		if(++responseCounter >= 2){
			loader.remove(wkArtCom);

			Wikia.processStyle(styles);
			wkComm.insertAdjacentHTML('beforeend', commentsHTML);
			Wikia.processScript(scripts);

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
		loader.show(wkArtCom, {center: true, size:'40px'});

		Wikia.nirvana.sendRequest({
			controller: 'ArticleCommentsController',
			method: 'WikiaMobileCommentsPage',
			data: {
				articleID: wgArticleId,
				page: 1
			},
			format: 'html',
			type: 'GET',
			callback: function(res){
				commentsHTML = res;
				show();
			}
		});

		Wikia.getMultiTypePackage({
			styles: '/extensions/wikia/ArticleComments/css/ArticleComments.wikiamobile.scss',
			messages: 'WikiaMobileComments',
			scripts: 'articlecomments_js_wikiamobile',
			params: {
				uselang: wgUserLanguage//ensure per-language Varnish cache
			},
			//ttl: 86400,
			callback: function(res){
				styles = res.styles;
				scripts = res.scripts.join('');
				show();
			}
		});
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