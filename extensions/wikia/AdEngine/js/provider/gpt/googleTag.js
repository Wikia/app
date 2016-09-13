/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.googleTag', [
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (helper, adLogicPageViewCounter, doc, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.googleTag',
		registeredCallbacks = {},
		//slot id (adUnit) => google slot
		slots = {},
		//slot id (adUnit) => slot name
		slotIdsMap = {},
		slotQueue = [],
		pageLevelParams,
		initialized = false;

	function dispatchEvent(event) {
		var id;

		log(['dispatchEvent', event], 'info', logGroup);

		for (id in registeredCallbacks) {
			if (registeredCallbacks.hasOwnProperty(id) &&
				registeredCallbacks[id] && event.slot && event.slot === slots[id]
			) {
				log(['dispatchEvent', event, id, 'Launching registered callback'], 'debug', logGroup);
				registeredCallbacks[id](event);
				return;
			}
		}

		log(['dispatchEvent', event, 'No callback registered for this slot render ended event'], 'error', logGroup);
	}

	function push(callback) {
		window.googletag.cmd.push(callback);
	}

	function enableServices() {
		log(['enableServices', 'push'], 'info', logGroup);
		push(function () {
			window.googletag.pubads().collapseEmptyDivs();
			window.googletag.pubads().enableSingleRequest();
			window.googletag.pubads().disableInitialLoad(); // manually request ads using refresh
			window.googletag.pubads().addEventListener('slotRenderEnded', dispatchEvent);

			window.googletag.enableServices();

			log(['enableServices', 'push', 'done'], 'debug', logGroup);
		});
	}

	function init() {
		log('init', 'debug', logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		window.googletag = window.googletag || {};
		window.googletag.cmd = window.googletag.cmd || [];
		if (!window.googletag.apiReady && !helper.isBlocking()) {
			gads.async = true;
			gads.type = 'text/javascript';
			gads.src = '//www.googletagservices.com/tag/js/gpt.js';
			log('Appending GPT script to head', 'debug', logGroup);
			node.parentNode.insertBefore(gads, node);
		}

		initialized = true;
		enableServices();
	}

	function isInitialized() {
		log(['isInitialized', initialized], 'debug', logGroup);
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
						log(['setPageLevelParams', 'pubAds.setTargeting', name, value], 'debug', logGroup);
						window.googletag.pubads().setTargeting(name, value);
					}
				}
			}
		});
	}

	function flush() {
		if (!isInitialized()) {
			log(['flush', 'done', 'No slots to flush'], 'info', logGroup);
			return;
		}

		push(function () {
			log(['flush', 'start'], 'info', logGroup);

			log(['flush', 'refresh', slotQueue], 'debug', logGroup);
			if (slotQueue.length) {
				window.googletag.pubads().refresh(slotQueue, {changeCorrelator: false});
				slotQueue = [];
			}

			log(['flush', 'done'], 'info', logGroup);
		});
	}

	function addSlot(adElement) {
		var sizes = adElement.getSizes(),
			slot = slots[adElement.getId()],
			slotId = adElement.getId();

		log(['addSlot', adElement], 'debug', logGroup);

		adElement.setPageLevelParams(pageLevelParams);
		if (!slot) {
			if (sizes) {
				slot = window.googletag.defineSlot(adElement.getSlotPath(), sizes, slotId);
			} else {
				slot = window.googletag.defineOutOfPageSlot(adElement.getSlotPath(), slotId);
			}
			slot.addService(window.googletag.pubads());
			window.googletag.display(slotId);
			slots[slotId] = slot;
			slotIdsMap[slotId] = adElement.getSlotName();
		}

		adElement.configureSlot(slot);
		slotQueue.push(slot);

		return slot;
	}

	function registerCallback(id, callback) {
		log(['registerCallback', id], 'info', logGroup);
		registeredCallbacks[id] = callback;
	}

	function onAdLoad(slotName, element, gptEvent, onAdLoadCallback) {
		log(['onAdLoad', slotName], 'info', logGroup);
		var iframe = element.getNode().querySelector('div[id*="_container_"] iframe');

		onAdLoadCallback(element.getId(), gptEvent, iframe);
	}

	function destroySlots(slotsNames) {
		var slotsToDestroy = [],
			allSlots = window.googletag.getSlots(),
			success;

		// when nothing passed - destroy all slots
		if (!slotsNames) {
			push(function () {
				log(['destroySlots', allSlots], 'debug', logGroup);
				success = window.googletag.destroySlots();

				if (!success) {
					log(['destroySlots', allSlots, 'failed'], 'error', logGroup);
				}

				allSlots.forEach(function (slot) {
					slots[slot.getSlotElementId()] = undefined;
				});
			});
		}

		slotsNames.forEach(function (slotName) {
			allSlots.forEach(function (slot) {
				if (slotIdsMap[slot.getSlotElementId()] === slotName) {
					slotsToDestroy.push(slot);
				}
			});
		});

		if (slotsToDestroy.length) {
			push(function () {
				log(['destroySlots', slotsNames], 'debug', logGroup);
				success = window.googletag.destroySlots(slotsToDestroy);

				if (!success) {
					log(['destroySlots', slotsNames, 'failed'], 'error', logGroup);
				}

				slotsToDestroy.forEach(function (slot) {
					slots[slot.getSlotElementId()] = undefined;
				});
			});
		}
	}

	function newPageView() {
		adLogicPageViewCounter.increment();
		window.googletag.pubads().updateCorrelator();
	}

	return {
		addSlot: addSlot,
		destroySlots: destroySlots,
		flush: flush,
		init: init,
		isInitialized: isInitialized,
		newPageView: newPageView,
		onAdLoad: onAdLoad,
		push: push,
		registerCallback: registerCallback,
		setPageLevelParams: setPageLevelParams
	};
});
