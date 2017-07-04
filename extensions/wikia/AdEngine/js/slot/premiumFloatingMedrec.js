/*global define*/
define('ext.wikia.adEngine.slot.premiumFloatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.service.viewabilityHandler',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (
	adContext,
	viewabilityHandler,
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
			maxChanges = 6,
			onScroll,
			placeHolder = doc.getElementById('WikiaAdInContentPlaceHolder'),
			recirculation = doc.getElementById('recirculation-rail'),
			refresh = {
				refreshAdPos: 0,
				lastRefreshTime: new Date(),
				refreshNumber: 0,
				adVisible: true,
				heightScrolledThreshold: 10,
				refreshDelay: 10000
			},
			slotName = 'INCONTENT_BOXAD_1',
			startPosition = placeHolder.offsetTop,
			swapRecirculationAndAd;

		adSlot.className = 'wikia-ad';
		adSlot.setAttribute('id', slotName);

		function shouldSwitchModules(currentHeightPosition) {
			var heightScrolled = Math.abs(currentHeightPosition - refresh.refreshAdPos),
				timeDifference = (new Date()) - refresh.lastRefreshTime,
				result = heightScrolled > refresh.heightScrolledThreshold &&
					timeDifference > refresh.refreshDelay &&
					refresh.refreshNumber < maxChanges;

			if (result) {
				refresh.lastRefreshTime = new Date();
				refresh.refreshAdPos = currentHeightPosition;
				refresh.refreshNumber++;
			}

			return result;
		}

		swapRecirculationAndAd = throttle(function () {
			if (shouldSwitchModules(placeHolder.offsetTop)) {
				if (refresh.adVisible) {
					log(['swapRecirculationAndAd', 'Hide ad, show recirculation '], 'debug', logGroup);
					adSlot.classList.add('hidden');
					recirculation.style.display = 'block';
				} else {
					log(['swapRecirculationAndAd', 'Show ad, hide recirculation '], 'debug', logGroup);
					viewabilityHandler.refreshOnView(slotName, 0);
					recirculation.style.display = 'none';
				}

				refresh.adVisible = !refresh.adVisible;
			}
		});

		onScroll = throttle(function () {
			if (startPosition < placeHolder.offsetTop && shouldSwitchModules(placeHolder.offsetTop)) {
				log(['checkAndPushAd', 'Enabling floating medrec'], 'debug', logGroup);

				placeHolder.appendChild(adSlot);
				recirculation.style.display = 'none';

				win.addEventListener('scroll', swapRecirculationAndAd);

				refresh.refreshAdPos = placeHolder.offsetTop;
				// Give add some time to call success. Otherwise swap with recirculation
				refresh.lastRefreshTime = new Date() + refresh.refreshDelay;

				win.adslots2.push({
					slotName: slotName,
					onSuccess: function () {
						refresh.lastRefreshTime = new Date();
					}
				});

				win.removeEventListener('scroll', onScroll);
			}
		});

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
		}

		start();
	}

	return {
		init: init
	};
});
