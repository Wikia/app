/*global define*/
define('ext.wikia.adEngine.wad.btRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.utils.scriptLoader',
	'wikia.document',
	'wikia.querystring',
	'wikia.window'
], function (adContext, DOMElementTweaker, scriptLoader, doc, qs, win) {
	'use strict';

	var wikiaApiController = 'AdEngine2ApiController',
		wikiaApiMethod = 'getBTCode',
		placementClass = 'bt-uid-tg',
		placementsMap = {
			TOP_LEADERBOARD: {
				uid: '5b33d3584c-188',
				style: 'margin:10px 0; z-index:100;',
				size: {
					width: 728,
					height: 90
				},
				lazy: false
			},
			TOP_RIGHT_BOXAD: {
				uid: '5b2d1649b2-188',
				style: 'margin-bottom:10px; z-index:100;',
				size: {
					width: 300,
					height: 250
				},
				lazy: false
			},
			INCONTENT_BOXAD_1: {
				uid: '5bbe13967e-188',
				style: 'z-index:100;',
				size: {
					width: 300,
					height: 250
				},
				lazy: true
			},
			BOTTOM_LEADERBOARD: {
				uid: '5b8f13805d-188',
				style: 'margin-bottom:23px; z-index:100;',
				size: {
					width: 728,
					height: 90
				},
				lazy: true
			}
		},
		isDebug = qs().getVal('bt-rec-debug', '') === '1';

	function markAdSlots() {
		Object
			.keys(placementsMap)
			.forEach(function (key) {
				if (!placementsMap[key].lazy) {
					duplicateSlot(key);
				}
			});
	}

	function duplicateSlot(slotName) {
		var slot = doc.getElementById(slotName);

		if (slot) {
			var node = doc.createElement('span');

			DOMElementTweaker.addClass(node, placementClass);
			DOMElementTweaker.setData(node, 'uid', placementsMap[slotName].uid);
			DOMElementTweaker.setData(node, 'style', placementsMap[slotName].style);

			if (isDebug) {
				node.style = placementsMap[slotName].style + ' width: ' + placementsMap[slotName].size.width + 'px; height: '
					+ placementsMap[slotName].size.height + 'px; background: #00D6D6; display: inline-block;';
			} else {
				DOMElementTweaker.hide(node, true);
			}

			slot.parentNode.insertBefore(node, slot.previousSibling);

			return node;
		}

		return false;
	}

	function injectScript() {
		markAdSlots();

		var url = win.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod;

		if (!isDebug) {
			scriptLoader.loadScript(url, {
				isAsync: false,
				node: doc.head.lastChild
			});
		}
	}

	function triggerScript() {
		if (!isDebug && win && win.BT && win.BT.clearThrough) {
			win.BT.clearThrough();
		}
	}

	function init() {
		doc.addEventListener('bab.blocking', injectScript);
	}

	return {
		duplicateSlot: duplicateSlot,
		init: init,
		triggerScript: triggerScript
	};
});
