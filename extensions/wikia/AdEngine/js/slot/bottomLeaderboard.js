/*global define*/
define('ext.wikia.adEngine.slot.bottomLeaderboard', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'wikia.document',
	'wikia.domCalculator',
	'wikia.log',
	'wikia.throttle',
	'wikia.viewportObserver',
	'wikia.window'
], function (
	adContext,
	eventDispatcher,
	doc,
	dom,
	log,
	throttle,
	viewportObserver,
	win
) {
	'use strict';

	var slotName = 'BOTTOM_LEADERBOARD',
		breakSlots = ['TOP_RIGHT_BOXAD'],
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

				if (adContext.get('opts.isBLBViewportEnabled') &&
					doc.getElementsByTagName('body')[0].className.indexOf('uap-skin') === -1 &&
					viewportObserver.sameViewport(slotName, breakSlots)) {
					eventDispatcher.dispatch('adengine.slot.status', {
						slot: {
							name: slotName
						},
						status: 'viewport',
						adInfo: {}
					});
					log(['pushSlot', 'Same viewport ' + slotName], 'debug', logGroup);
				} else {
					win.adslots2.push(slotName);
					log(['pushSlot', 'Pushed ' + slotName], 'debug', logGroup);
				}
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
