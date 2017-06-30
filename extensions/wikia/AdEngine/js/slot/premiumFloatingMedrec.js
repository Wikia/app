/*global define*/
define('ext.wikia.adEngine.slot.premiumFloatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (
	adContext,
	doc,
	log,
	throttle,
	win
) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.slot.premiumFloatingMedrec';

	function init() {
		var adSlot = doc.createElement('div'),
			context = adContext.getContext(),
			placeHolder = doc.getElementById('WikiaAdInContentPlaceHolder'),
			recirculation = doc.getElementById('recirculation-rail'),
			slotName = 'INCONTENT_BOXAD_1',
			startPosition = placeHolder.offsetTop;

		adSlot.className = 'wikia-ad';
		adSlot.setAttribute('id', slotName);

		function start() {
			if (!context.opts.floatingMedrec) {
				log(['init', 'Floating medrec disabled: ad context returns false'], 'debug', logGroup);
				return;
			}

			if (!win.wgIsContentNamespace) {
				log(['init', 'Floating medrec disabled: $wgIsContentNamespace equals false'], 'debug', logGroup);
				return;
			}

			if (!placeHolder) {
				log(['init', 'Floating medrec disabled: no placeHolder'], 'debug', logGroup);
				return;
			}

			win.addEventListener('scroll', onScroll);
			win.addEventListener('resize', onScroll);
		}

		function onScroll() {
			throttle(checkAndPushAd)();
		}

		function checkAndPushAd() {
			if (startPosition < placeHolder.offsetTop) {
				log(['checkAndPushAd', 'Enabling floating medrec'], 'debug', logGroup);

				placeHolder.appendChild(adSlot);
				recirculation.style.display = 'none';

				win.adslots2.push({
					slotName: slotName,
					onSuccess: function () {
						// TODO add refreshing logic
					}
				});

				win.removeEventListener('scroll', onScroll);
				win.removeEventListener('resize', onScroll);
			}
		}

		start();
	}

	return {
		init: init
	};
});
