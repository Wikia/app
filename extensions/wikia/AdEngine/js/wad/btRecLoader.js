/*global define*/
define('ext.wikia.adEngine.wad.btRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.window'
], function (adContext, DOMElementTweaker, scriptLoader, doc, win) {
	'use strict';

	var wikiaApiController = 'AdEngine2ApiController',
		wikiaApiMethod = 'getBTCode',
		placementClass = 'bt-uid-tg',
		placementsMap = {
			TOP_LEADERBOARD: {
				uid: '5b33d3584c-188',
				style: 'margin: 10px 0;'
			},
			TOP_RIGHT_BOXAD: {
				uid: '5b2d1649b2-188',
				style: 'margin-bottom: 10px;'
			},
			BOTTOM_LEADERBOARD: {
				uid: '5b7f2041a8-188',
				style: ''
			}
		};

	function markAdSlots(replace) {
		Object
			.keys(placementsMap)
			.forEach(function (key) {
				var slot = doc.getElementById(key);

				if (slot) {
					if (replace) {
						DOMElementTweaker.addClass(slot, placementClass);
						DOMElementTweaker.setData(slot, 'uid', placementsMap[key].uid);
						DOMElementTweaker.setData(slot, 'style', placementsMap[key].style);
					} else {
						var node = doc.createElement('span');

						DOMElementTweaker.addClass(node, placementClass);
						DOMElementTweaker.setData(node, 'uid', placementsMap[key].uid);
						DOMElementTweaker.setData(node, 'style', placementsMap[key].style);
						DOMElementTweaker.hide(node, true);

						slot.parentNode.insertBefore(node, slot.previousSibling);
					}
				}
			});
	}

	function injectScript() {
		var url = win.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod;

		scriptLoader.loadScript(url, {
			isAsync: false,
			node: doc.head.lastChild
		});
	}

	function init() {
		markAdSlots(false);

		doc.addEventListener('bab.blocking', injectScript);
	}

	return {
		init: init
	};
});
