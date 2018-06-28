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
		wikiaApiMethod = 'getBlockthroughCode',
		placementClass = 'bt-uid-tg',
		placementsMap = {
			TOP_LEADERBOARD: '5b33d3584c-188',
			TOP_RIGHT_BOXAD: '5b2d1649b2-188'
		};

	function markAdSlots(replace) {
		Object
			.keys(placementsMap)
			.forEach(function (key) {
				var slot = doc.getElementById(key);

				if (slot) {
					if (replace) {
						DOMElementTweaker.addClass(slot, placementClass);
						DOMElementTweaker.setData(slot, 'uid', placementsMap[key]);
					} else {
						var node = doc.createElement('span');

						DOMElementTweaker.addClass(node, placementClass);
						DOMElementTweaker.setData(node, 'uid', placementsMap[key]);
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
		markAdSlots();

		if (adContext.get('opts.babRecovery')) {
			doc.addEventListener('bab.blocking', injectScript);
		} else {
			injectScript(false);
		}
	}

	return {
		init: init
	};
});
