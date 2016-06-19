/*global define*/
define('ext.wikia.adEngine.slot.bottomLeaderboard', [
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.provider.btfBlocker',
	'ext.wikia.adEngine.utils.domCalculator',
	'wikia.document',
	'wikia.log',
	'wikia.window',
], function (adHelper, btfBlocker, dom, doc, log, win) {
	'use strict';

	var slotName = 'BOTTOM_LEADERBOARD',
		mainContent = doc.getElementById('WikiaMainContent'),
		threshold = 100,
		viewPortHeight = Math.max(doc.documentElement.clientHeight, win.innerHeight || 0),
		logGroup = 'ext.wikia.adEngine.slot.bottomLeaderboard',
		pushed = false,

		pushSlot = adHelper.throttle(function () {
			var scrollPosition = win.scrollY || win.pageYOffset || doc.documentElement.scrollTop,
				pushPos = dom.getTopOffset(mainContent) + mainContent.offsetHeight - viewPortHeight - threshold;

			if (!pushed && pushPos < scrollPosition) {
				pushed = true;
				doc.removeEventListener('scroll', pushSlot);
				btfBlocker.unblock(slotName);
				win.adslots2.push(slotName);
				log(['pushSlot', 'Pushed BFAB'], 'debug', logGroup);
			}
		});

	function init() {
		if (!doc.getElementById(slotName)) {
			log(['init', 'No ' + slotName], 'error', logGroup);
			return;
		}

		doc.addEventListener('scroll', pushSlot);
	}

	return {
		init: init
	};
});
