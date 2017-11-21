/*global define Promise*/
define('ext.wikia.adEngine.slot.floatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.uapContext',
	'ext.wikia.adEngine.slot.service.viewabilityHandler',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (
	adContext,
	uapContext,
	viewabilityHandler,
	doc,
	log,
	throttle,
	win
) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.slot.floatingMedrec';

	function init() {
		var adSlot = doc.createElement('div'),
			context = adContext.getContext(),
			maxChanges = 6,
			onScroll,
			placeHolderElement = doc.getElementById('WikiaAdInContentPlaceHolder'),
			recirculationElement = doc.getElementById('recirculation-rail'),
			refreshInfo = {
				refreshAdPos: 0,
				lastRefreshTime: new Date(),
				refreshNumber: 0,
				adVisible: true,
				heightScrolledThreshold: 10,
				refreshDelay: 10000
			},
			slotName = 'INCONTENT_BOXAD_1',
			startPosition = placeHolderElement.offsetTop,
			swapRecirculationAndAd;

		adSlot.className = 'wikia-ad';
		adSlot.setAttribute('id', slotName);

		function hasUserScrolledEnoughDistance(currentHeightPosition) {
			var heightScrolled = Math.abs(currentHeightPosition - refreshInfo.refreshAdPos);
			return heightScrolled > refreshInfo.heightScrolledThreshold;
		}

		function wasItEnoughTimeSinceLastRefresh() {
			var timeDifference = (new Date()) - refreshInfo.lastRefreshTime;
			return timeDifference > refreshInfo.refreshDelay;
		}

		function isMaxNumberOfRefreshReached() {
			return refreshInfo.refreshNumber >= maxChanges;
		}

		function isUAPFloatingMedrecVisible() {
			var isAdVisible = refreshInfo.adVisible && refreshInfo.refreshNumber !== 0;
			return uapContext.isUapLoaded() && isAdVisible;
		}

		function shouldSwitchModules(currentHeightPosition) {
			return hasUserScrolledEnoughDistance(currentHeightPosition) &&
				wasItEnoughTimeSinceLastRefresh() &&
				!isMaxNumberOfRefreshReached() &&
				!isUAPFloatingMedrecVisible();
		}

		function updateModulesRefreshInformation(currentHeightPosition) {
			refreshInfo.lastRefreshTime = new Date();
			refreshInfo.refreshAdPos = currentHeightPosition;
			refreshInfo.refreshNumber++;
		}

		function showRecirculation() {
			recirculationElement.style.display = 'block';
		}

		function hideRecirculation() {
			recirculationElement.style.display = 'none';
		}

		function refreshAd() {
			return new Promise(function (resolve, reject) {
				viewabilityHandler.refreshOnView(slotName, 0, {
					onSuccess: resolve
				});
			});
		}

		swapRecirculationAndAd = throttle(function () {
			if (shouldSwitchModules(placeHolderElement.offsetTop)) {
				updateModulesRefreshInformation(placeHolderElement.offsetTop);
				if (refreshInfo.adVisible) {
					log(['swapRecirculationAndAd', 'Hide ad, show recirculation '], 'debug', logGroup);
					adSlot.classList.add('hidden');
					showRecirculation();
				} else {
					log(['swapRecirculationAndAd', 'Show ad, hide recirculation '], 'debug', logGroup);
					refreshAd()
						.then(hideRecirculation);
				}

				refreshInfo.adVisible = !refreshInfo.adVisible;
			}
		});

		onScroll = throttle(function () {
			if (startPosition < placeHolderElement.offsetTop && shouldSwitchModules(placeHolderElement.offsetTop)) {
				updateModulesRefreshInformation(placeHolderElement.offsetTop);
				log(['checkAndPushAd', 'Enabling floating medrec'], 'debug', logGroup);

				placeHolderElement.appendChild(adSlot);

				win.addEventListener('scroll', swapRecirculationAndAd);

				refreshInfo.refreshAdPos = placeHolderElement.offsetTop;
				// Give add some time to call success. Otherwise swap with recirculation
				refreshInfo.lastRefreshTime = (new Date()).getTime() + refreshInfo.refreshDelay;

				win.adslots2.push({
					slotName: slotName,
					onSuccess: function () {
						hideRecirculation();
						refreshInfo.lastRefreshTime = (new Date()).getTime();
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

			if (!placeHolderElement) {
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
