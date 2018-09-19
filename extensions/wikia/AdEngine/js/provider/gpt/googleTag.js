/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.googleTag', [
	'ext.wikia.adEngine',
	'ext.wikia.adEngine.provider.gpt.googleSlots',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.slot.service.srcProvider',
	'wikia.document',
	'wikia.log',
	'wikia.trackingOptIn',
	'wikia.window'
], function (adEngine3, googleSlots, adSlot, slotRegistry, srcProvider, doc, log, trackingOptIn, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.googleTag',
		slotQueue = [],
		pageLevelParams,
		initialized = false;

	win.googletag = win.googletag || {};
	win.googletag.cmd = win.googletag.cmd || [];

	function collapseIfSlotHasViewportConflicts(slotName) {
		var slot = adEngine3.slotService.get(slotName);

		if (adEngine3.slotService.hasViewportConflict(slot)) {
			slot.collapse({ adType: 'viewport-conflict' });

			return true;
		}

		return false;
	}

	function dispatchEvent(event, methodName) {
		var slot,
			slotName = adSlot.getShortSlotName(event.slot.getName());

		log(['dispatchEvent', event], log.levels.info, logGroup);
		slot = slotRegistry.get(slotName);

		if (slot && slot[methodName]) {
			slot[methodName](event);
		} else {
			log(['dispatchEvent', event, 'Slot not registered'], log.levels.error, logGroup);
		}
	}

	function push(callback) {
		win.googletag.cmd.push(callback);
	}

	function setupNonPersonalizedAds() {
		win.googletag.pubads().setRequestNonPersonalizedAds(trackingOptIn.isOptedIn() ? 0 : 1);
	}

	function enableServices() {
		log(['enableServices', 'push'], log.levels.info, logGroup);
		push(function () {
			win.googletag.pubads().collapseEmptyDivs();
			win.googletag.pubads().enableSingleRequest();
			win.googletag.pubads().disableInitialLoad(); // manually request ads using refresh
			win.googletag.pubads().addEventListener('slotRenderEnded', function (event) {
				dispatchEvent(event, 'renderEnded');
			});
			win.googletag.pubads().addEventListener('impressionViewable', function (event) {
				dispatchEvent(event, 'viewed');
			});
			setupNonPersonalizedAds();

			win.googletag.enableServices();

			log(['enableServices', 'push', 'done'], log.levels.debug, logGroup);
		});
	}

	/**
	 * Load GPT if not loaded only.
	 *
	 * @returns {boolean}
	 */
	function canGptBeLoaded() {
		return !win.googletag.apiReady;
	}

	function init() {
		log('init', log.levels.debug, logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		if (canGptBeLoaded()) {
			gads.async = true;
			gads.type = 'text/javascript';
			gads.src = '//www.googletagservices.com/tag/js/gpt.js';
			log('Appending GPT script to head', log.levels.debug, logGroup);
			node.parentNode.insertBefore(gads, node);
		}

		initialized = true;
		enableServices();
	}

	function isInitialized() {
		log(['isInitialized', initialized], log.levels.debug, logGroup);
		return initialized;
	}

	function setPageLevelParams(params) {
		push(function () {
			var name,
				value;

			pageLevelParams = params;
			for (name in pageLevelParams) {
				if (pageLevelParams.hasOwnProperty(name)) {
					value = pageLevelParams[name];
					if (value) {
						log(['setPageLevelParams', 'pubAds.setTargeting', name, value], log.levels.debug, logGroup);
						win.googletag.pubads().setTargeting(name, value);
					}
				}
			}
		});
	}

	function flush() {
		if (!isInitialized()) {
			log(['flush', 'done', 'No slots to flush'], log.levels.info, logGroup);
			return;
		}

		push(function () {
			log(['flush', 'start'], log.levels.info, logGroup);

			log(['flush', 'refresh', slotQueue], log.levels.debug, logGroup);
			if (slotQueue.length) {
				win.googletag.pubads().refresh(slotQueue, {changeCorrelator: false});

				slotQueue = [];
			}

			log(['flush', 'done'], log.levels.info, logGroup);
		});
	}

	function addSlot(adElement) {
		var defaultSizes = adElement.getDefaultSizes(),
			sizeMap = adElement.getSizes(),
			slotId = adElement.getId(),
			slot = googleSlots.getSlot(slotId);

		log(['addSlot', adElement], log.levels.debug, logGroup);

		adElement.setPageLevelParams(pageLevelParams);
		adElement.setSlotLevelParams();

		if (collapseIfSlotHasViewportConflicts(adElement.getSlotName())) {
			return;
		}

		if (!slot) {
			slot = (defaultSizes || !sizeMap.isEmpty()) ?
				win.googletag.defineSlot(adElement.getSlotPath(), defaultSizes, slotId) :
				win.googletag.defineOutOfPageSlot(adElement.getSlotPath(), slotId);

			if (!sizeMap.isEmpty()) {
				slot.defineSizeMapping(sizeMap.build());
			}

			slot.addService(win.googletag.pubads());
			win.googletag.display(slotId);
			googleSlots.addSlot(slot);
		}

		adElement.configureSlot(slot);
		slotQueue.push(slot);

		return slot;
	}

	function refreshSlot(slot) {
		win.googletag.pubads().refresh([slot]);
	}

	function onAdLoad(slotName, element, gptEvent, onAdLoadCallback) {
		log(['onAdLoad', slotName], log.levels.info, logGroup);
		var iframe = adSlot.getIframe(slotName);

		onAdLoadCallback(element.getId(), gptEvent, iframe);
	}

	function isGoogleTagLoaded() {
		return typeof win.googletag.pubads === 'function';
	}

	function destroySlots(slotsNames) {
		var allSlots,
			slotsToDestroy = [],
			success;

		if (!isInitialized()) {
			return;
		}

		if (!isGoogleTagLoaded()) {
			log(['destroySlots', 'pubads not yet available', 'resetting cmd'], log.levels.info, logGroup);
			win.googletag.cmd = [];
			enableServices();
			return;
		}

		allSlots = win.googletag.pubads().getSlots();
		// when nothing passed - destroy all slots
		if (!slotsNames) {
			slotsToDestroy = allSlots;
		} else {
			allSlots.forEach(function (slot) {
				var slotsPositionTargeting = slot.getTargeting('pos');

				// google returns array
				// - in our case it has always one element and this element is the one we are interested in
				if (!slotsPositionTargeting.length) {
					log(['destroySlots', 'getTargeting doesn\'t return pos', slotsPositionTargeting, slot], log.levels.error, logGroup);
				} else {
					if (slotsNames.indexOf(slotsPositionTargeting[0]) > -1) {
						slotsToDestroy.push(slot);
						adEngine3.slotService.clearSlot(slotsPositionTargeting[0]);
					}
				}
			});
		}

		if (slotsToDestroy.length) {
			push(function () {
				log(['destroySlots', slotsNames, slotsToDestroy], log.levels.debug, logGroup);
				success = win.googletag.destroySlots(slotsToDestroy);

				if (!success) {
					log(['destroySlots', slotsNames, slotsToDestroy, 'failed'], log.levels.error, logGroup);
				}

				googleSlots.removeSlots(slotsToDestroy);
			});
		} else {
			log(['destroySlots', 'no slots returned to destroy', allSlots, slotsNames], log.levels.debug, logGroup);
		}
	}

	function updateCorrelator() {
		push(function () {
			win.googletag.pubads().updateCorrelator();
		});
	}

	return {
		addSlot: addSlot,
		destroySlots: destroySlots,
		flush: flush,
		init: init,
		isInitialized: isInitialized,
		onAdLoad: onAdLoad,
		push: push,
		refreshSlot: refreshSlot,
		setPageLevelParams: setPageLevelParams,
		setupNonPersonalizedAds: setupNonPersonalizedAds,
		updateCorrelator: updateCorrelator
	};
});
