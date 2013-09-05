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
		clickEvent = 'click';

	if(hash.indexOf('comm-') > -1){
		open = hash.slice(5);
	}

	function show(commentsHTML, assets){
		throbber.remove(wkArtCom);

		loader.processStyle(assets.styles);
		wkComm.insertAdjacentHTML('beforeend', commentsHTML[0]);
		loader.processScript(assets.scripts.join(''));

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

		collSec.removeEventListener(clickEvent, init, true);
	}

	function init(){
		throbber.show(wkArtCom, {center: true, size:'40px'});

		$.when(
			nirvana.sendRequest({
				controller: 'ArticleComments',
				method: 'WikiaMobileCommentsPage',
				data: {
					articleID: wgArticleId,
					page: 1
				},
				format: 'html',
				type: 'GET'
			}),
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
			})
		).done(show);
	}

	$(function(){
		wkArtCom = document.getElementById('wkArtCom');
		collSec = wkArtCom.getElementsByClassName('collSec')[0];
		wkComm = document.getElementById('wkComm');

		if(open){
			init();
			collSec.className += ' open';
			wkComm.className += ' open';
		}else{
			$(collSec).one(clickEvent, init);
		}
	});
});