/**
 * Article Comments initialization for the WikiaMobile skin
 * This is loaded on any page that supports commenting and will load the full ArticleComments
 * functionality on-demand
 *
 * @author Jakub 'Student' Olek
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 **/

(function () {
	'use strict';

	var throbber = require('throbber'),
		qs = require('wikia.querystring'),
		loader = require('wikia.loader'),
		nirvana = require('wikia.nirvana'),
		sloth = require('sloth'),
		hash = qs().getHash(),
		wkArtCom = document.getElementById('wkArtCom'),
		open,
		wkComm = document.getElementById('wkComm'),
		clickEvent = 'click';

	if (hash.indexOf('comm-') > -1){
		open = hash.slice(5);
	}

	function show(commentsHTML, assets){
		throbber.remove(wkArtCom);

		loader.processStyle(assets.styles);
		wkComm.insertAdjacentHTML('beforeend', commentsHTML[0]);
		loader.processScript(assets.scripts.join(''));

		if (open){
			var elm = document.getElementById(open);

			if (elm){
				setTimeout(function(){
					elm.scrollIntoView();
				}, 500);

				if (elm.nodeName == 'LI'){
					setTimeout(function () {
						var evObj = document.createEvent('MouseEvents');
						evObj.initMouseEvent(clickEvent, true, true, window);
						elm.getElementsByClassName('cmnRpl')[0].dispatchEvent(evObj);
					}, 1500);
				}
			}
		}
	}

	function init(){
		throbber.show(wkArtCom, {center: true, size:'40px'});

		$.when(
			nirvana.sendRequest({
				controller: 'ArticleComments',
				method: 'WikiaMobileCommentsPage',
				data: {
					articleID: window.wgArticleId,
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
						uselang: window.wgUserLanguage//ensure per-language Varnish cache
					}
				}
			})
		).done(show);
	}

	sloth({
		on: wkArtCom,
		callback: init
	});
})();
