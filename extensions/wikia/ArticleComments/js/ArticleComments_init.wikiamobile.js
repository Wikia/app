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
		clickEvent = events.click;

	if(hash.indexOf('comm-') > -1){
		open = hash.slice(6);
	}

	function init(){
		loader.show(wkArtCom, {center: true, size:'40px'});

		Wikia.getMultiTypePackage({
			styles: '/extensions/wikia/ArticleComments/css/ArticleComments.wikiamobile.scss',
			messages: 'WikiaMobileComments',
			scripts: 'articlecomments_js_wikiamobile',
			templates: [{
				controllerName: 'ArticleCommentsModule',
				methodName: 'WikiaMobileCommentsPage',
				params: {
					articleID: wgArticleId,
					page: 1
				}
			}],
			params: {
				useskin: 'wikiamobile',
				uselang: window.wgUserLanguage
			},
			varnishTTL: 86400,
			callback: function(res){
				loader.remove(wkArtCom);
				Wikia.processStyle(res.styles);
				wkComm.insertAdjacentHTML('beforeend', res.templates['ArticleCommentsModule_WikiaMobileCommentsPage']);
				Wikia.processScript(res.scripts[0]);
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
		});
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
			collSec.addEventListener(clickEvent, init, true);
		}
	});
});