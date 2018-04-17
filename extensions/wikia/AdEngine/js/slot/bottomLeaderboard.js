/*global define*/
define('ext.wikia.adEngine.slot.bottomLeaderboard', [
	'wikia.document',
	'wikia.domCalculator',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (doc, dom, log, throttle, win) {
	'use strict';

	var slotName = 'BOTTOM_LEADERBOARD',
		threshold = 100,
		viewPortHeight = Math.max(doc.documentElement.clientHeight, win.innerHeight || 0),
		logGroup = 'ext.wikia.adEngine.slot.bottomLeaderboard',
		pushed = false,
		wikiaFooter,

		pushSlot = throttle(function () {
			var scrollPosition = win.scrollY || win.pageYOffset || doc.documentElement.scrollTop,
				pushPos = dom.getTopOffset(wikiaFooter) - viewPortHeight - threshold;

			if (win.ArticleComments && !win.ArticleComments.initCompleted) {
				return;
			}

			if (!pushed && pushPos < scrollPosition) {
				pushed = true;
				doc.removeEventListener('scroll', pushSlot);
				win.adslots2.push(slotName);
				log(['pushSlot', 'Pushed ' + slotName], 'debug', logGroup);
			}
		});

	function init() {
		if (!doc.getElementById(slotName)) {
			log(['init', 'No ' + slotName], 'error', logGroup);
			return;
		}

		wikiaFooter = doc.getElementById('WikiaFooter');
		doc.addEventListener('scroll', pushSlot);
	}

	return {
		init: init
	};
});
