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
				style: 'margin:10px 0; z-index:100;',
				lazy: false
			},
			TOP_RIGHT_BOXAD: {
				uid: '5b2d1649b2-188',
				style: 'margin-bottom:10px; z-index:100;',
				lazy: false
			},
			BOTTOM_LEADERBOARD: {
				uid: '5b8f13805d-188',
				style: 'margin-bottom:23px; z-index:100;',
				lazy: true
			}
		};

	function markAdSlots(replace, lazySlotName) {
		Object
			.keys(placementsMap)
			.forEach(function (key) {
				if (
					(!lazySlotName && !placementsMap[key].lazy) ||
					(lazySlotName && lazySlotName === key && placementsMap[key].lazy)
				) {
					var slot = doc.getElementById(key);

					if (slot) {
						var slotOperation = replace ? replaceSlot : duplicateSlot;

						slotOperation(key, slot);
					}
				}
			});
	}

	function replaceSlot(key, slot) {
		DOMElementTweaker.addClass(slot, placementClass);
		DOMElementTweaker.setData(slot, 'uid', placementsMap[key].uid);
		DOMElementTweaker.setData(slot, 'style', placementsMap[key].style);
	}

	function duplicateSlot(key, slot) {
		var node = doc.createElement('span');

		DOMElementTweaker.addClass(node, placementClass);
		DOMElementTweaker.setData(node, 'uid', placementsMap[key].uid);
		DOMElementTweaker.setData(node, 'style', placementsMap[key].style);
		DOMElementTweaker.hide(node, true);

		slot.parentNode.insertBefore(node, slot.previousSibling);
	}

	function injectScript() {
		markAdSlots(false);

		var url = win.wgCdnApiUrl + '/wikia.php?controller=' + wikiaApiController + '&method=' + wikiaApiMethod;

		scriptLoader.loadScript(url, {
			isAsync: false,
			node: doc.head.lastChild
		});
	}

	function triggerScript() {
		win.BT.clearThrough();
	}

	function init() {
		doc.addEventListener('bab.blocking', injectScript);
	}

	return {
		init: init,
		markAdSlots: markAdSlots,
		triggerScript: triggerScript
	};
});
