/*global define*/
define('ext.wikia.adEngine.slot.floatingMedrec', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.slot.service.viewabilityHandler',
	'ext.wikia.adEngine.wad.babDetection',
	'ext.wikia.adEngine.wad.btRecLoader',
	'ext.wikia.adEngine.wad.wadRecRunner',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (
	adContext,
	adEngineBridge,
	viewabilityHandler,
	babDetection,
	btRecLoader,
	wadRecRunner,
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
			swapRecirculationAndAd,
			btRec = null,
			recSelector = 'div[id*="' + btRecLoader.getPlacementId(slotName) + '"]';

		adSlot.className = 'wikia-ad';
		adSlot.setAttribute('id', slotName);

		function applyRec(onSuccess) {
			if (!btRec) {
				return;
			}

			if (btRecLoader.duplicateSlot(slotName)) {
				btRecLoader.triggerScript();
			}

			if (onSuccess) {
				onSuccess();
			}
		}

		function removeRecNode() {
			var recNode = doc.querySelector(recSelector);

			if (recNode) {
				recNode.style.display = 'none';
				recNode.remove();
			}
		}

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
			return adEngineBridge.universalAdPackage.isFanTakeoverLoaded() && isAdVisible;
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

		function refreshAd(onSuccess) {
			viewabilityHandler.refreshOnView(slotName, 0, {
				onSuccess: onSuccess
			});
		}

		function onSlotFirstLoad() {
			hideRecirculation();
			refreshInfo.lastRefreshTime = (new Date()).getTime();
		}

		swapRecirculationAndAd = throttle(function () {
			if (shouldSwitchModules(placeHolderElement.offsetTop)) {
				updateModulesRefreshInformation(placeHolderElement.offsetTop);
				if (refreshInfo.adVisible) {
					log(['swapRecirculationAndAd', 'Hide ad, show recirculation '], 'debug', logGroup);
					adSlot.classList.add('hidden');
					removeRecNode();
					showRecirculation();
				} else {
					log(['swapRecirculationAndAd', 'Show ad, hide recirculation '], 'debug', logGroup);
					refreshAd(hideRecirculation);
					applyRec(hideRecirculation);
				}

				refreshInfo.adVisible = !refreshInfo.adVisible;
			}
		});

		onScroll = throttle(function () {
			if (startPosition < placeHolderElement.offsetTop && shouldSwitchModules(placeHolderElement.offsetTop)) {
				log(['checkAndPushAd', 'Enabling floating medrec'], 'debug', logGroup);
				updateModulesRefreshInformation(placeHolderElement.offsetTop);

				win.removeEventListener('scroll', onScroll);
				win.addEventListener('scroll', swapRecirculationAndAd);

				placeHolderElement.appendChild(adSlot);

				// Give some time to call success. Otherwise swap with recirculation
				refreshInfo.lastRefreshTime = (new Date()).getTime() + refreshInfo.refreshDelay;
				refreshInfo.refreshAdPos = placeHolderElement.offsetTop;

				if (btRec === null) {
					btRec = babDetection.isBlocking() && wadRecRunner.isEnabled('bt');
				}

				win.adslots2.push({
					slotName: slotName,
					onSuccess: onSlotFirstLoad
				});

				applyRec(onSlotFirstLoad);
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
