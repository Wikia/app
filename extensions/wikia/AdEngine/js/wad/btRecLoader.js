/*global define*/
define('ext.wikia.adEngine.wad.btRecLoader', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.domElementTweaker',
	'wikia.document',
], function (adContext, DOMElementTweaker, doc) {
	'use strict';

	var insertAsNew = true,
		wikiaScriptDomain = 'wikia-inc-com',
		placementClass = 'bt-uid-tg',
		placementsMap = {
			TOP_RIGHT_BOXAD: '5b2d1649b2-188'
		};

	function markAdSlots() {
		Object
			.keys(placementsMap)
			.forEach(function (key) {
				var slot = doc.getElementById(key);

				if (slot) {
					if (insertAsNew) {
						var node = doc.createElement('span');

						DOMElementTweaker.addClass(node, placementClass);
						DOMElementTweaker.setData(node, 'uid', placementsMap[key]);
						DOMElementTweaker.hide(node, true);

						slot.parentNode.insertBefore(node, slot.previousSibling);

					} else {
						DOMElementTweaker.addClass(slot, placementClass);
						DOMElementTweaker.setData(slot, 'uid', placementsMap[key]);
					}
				}
			});
	}

	function injectScript() {
		var scr = doc.createElement('script');

		scr.type = 'text/javascript';
		scr.src = 'https://' + wikiaScriptDomain + '.videoplayerhub.com/galleryloader.js';

		doc.getElementsByTagName('head')[0].appendChild(scr);
	}

	function init() {
		markAdSlots();

		if (adContext.get('opts.babRecovery')) {
			// ToDo: run on event
			injectScript();
		} else {
			injectScript();
		}
	}

	return {
		init: init
	};
});
