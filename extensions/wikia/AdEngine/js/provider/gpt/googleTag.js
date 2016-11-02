/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.googleTag', [
	'ext.wikia.adEngine.provider.gpt.googleSlots',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (googleSlots, adSlot, recovery, doc, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.googleTag',
		registeredCallbacks = {},
		slotQueue = [],
		pageLevelParams,
		initialized = false;

	window.googletag = window.googletag || {};
	window.googletag.cmd = window.googletag.cmd || [];

	function isSlotRegistered(slot, id) {
		return registeredCallbacks[id] && slot && slot === googleSlots.getSlot(id);
	}

	function dispatchEvent(event) {
		var id;

		log(['dispatchEvent', event], 'info', logGroup);
		for (id in registeredCallbacks) {
			if (registeredCallbacks.hasOwnProperty(id) && isSlotRegistered(event.slot, id)) {
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

		if (!window.googletag.apiReady && !recovery.isBlocking()) {
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
			slotId = adElement.getId(),
			slot = googleSlots.getSlot(slotId);

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
			googleSlots.addSlot(slot);
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
		var iframe = adSlot.getIframe(slotName);

		onAdLoadCallback(element.getId(), gptEvent, iframe);
	}

	function destroySlots(slotsNames) {
		var allSlots,
			slotsToDestroy = [],
			success;

		if (!isInitialized()) {
			return;
		}

		allSlots = window.googletag.pubads().getSlots();
		// when nothing passed - destroy all slots
		if (!slotsNames) {
			slotsToDestroy = allSlots;
		} else {
			allSlots.forEach(function (slot) {
				var slotsPositionTargeting = slot.getTargeting('pos');

				// google returns array
				// - in our case it has always one element and this element is the one we are interested in
				if (!slotsPositionTargeting.length) {
					log(['destroySlots', 'getTargeting doesn\'t return pos', slotsPositionTargeting, slot], 'error', logGroup);
				} else {
					if (slotsNames.indexOf(slotsPositionTargeting[0]) > -1) {
						slotsToDestroy.push(slot);
					}
				}
			});
		}

		if (slotsToDestroy.length) {
			push(function () {
				log(['destroySlots', slotsNames, slotsToDestroy], 'debug', logGroup);
				success = window.googletag.destroySlots(slotsToDestroy);

				if (!success) {
					log(['destroySlots', slotsNames, slotsToDestroy, 'failed'], 'error', logGroup);
				}

				googleSlots.removeSlots(slotsToDestroy);
			});
		} else {
			log(['destroySlots', 'no slots returned to destroy', allSlots, slotsNames], 'debug', logGroup);
		}
	}

	function updateCorrelator() {
		push(function() {
			window.googletag.pubads().updateCorrelator();
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
		registerCallback: registerCallback,
		setPageLevelParams: setPageLevelParams,
		updateCorrelator: updateCorrelator
	};
});
