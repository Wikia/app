/*global define*/
define('ext.wikia.adEngine.slot.bottomLeaderboard', [
	'ext.wikia.adEngine.utils.eventDispatcher',
	'ext.wikia.adEngine.wad.babDetection',
	'ext.wikia.adEngine.wad.btRecLoader',
	'ext.wikia.adEngine.wad.wadRecRunner',
	'wikia.document',
	'wikia.domCalculator',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (eventDispatcher, babDetection, btRecLoader, wadRecRunner, doc, dom, log, throttle, win) {
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
				eventDispatcher.dispatch('adengine.lookup.prebid.lazy', {});

				if (babDetection.isBlocking() && wadRecRunner.isEnabled('bt') && btRecLoader.duplicateSlot(slotName)) {
					btRecLoader.triggerScript();
				}

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
