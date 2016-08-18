/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.googleTag', [
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (helper, doc, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.googleTag',
		recoveryCmd = [],
		registeredCallbacks = {},
		slots = {},
		slotQueue = [],
		pageLevelParams;

	function GoogleTag() {
		this.initialized = false;
	}

	function dispatchEvent(event) {
		var id;

		log(['dispatchEvent', event], 'info', logGroup);

		for (id in registeredCallbacks) {
			if (registeredCallbacks.hasOwnProperty(id)) {
				if (registeredCallbacks[id] && event.slot && event.slot === slots[id]) {
					log(['dispatchEvent', event, 'Launching registered callback'], 'debug', logGroup);
					registeredCallbacks[id](event);
					return;
				}
			}
		}

		log(['dispatchEvent', event, 'No callback registered for this slot render ended event'], 'error', logGroup);
	}

	GoogleTag.prototype.enableServices = function () {
		log(['enableServices', 'push'], 'info', logGroup);
		this.push(function () {
			var pubAds = window.googletag.pubads();

			pubAds.collapseEmptyDivs();
			pubAds.enableSingleRequest();
			pubAds.disableInitialLoad(); // manually request ads using refresh
			pubAds.addEventListener('slotRenderEnded', dispatchEvent);

			window.googletag.enableServices();

			log(['enableServices', 'push', 'done'], 'debug', logGroup);
		});
	};

	GoogleTag.prototype.init = function () {
		log('init', 'debug', logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		window.googletag = window.googletag || {};
		window.googletag.cmd = window.googletag.cmd || [];

		if (!window.googletag.apiReady) {
			gads.async = true;
			gads.type = 'text/javascript';
			gads.src = '//www.googletagservices.com/tag/js/gpt.js';
			log('Appending GPT script to head', 'debug', logGroup);
			node.parentNode.insertBefore(gads, node);
		}

		this.initialized = true;
		this.enableServices();
	};

	GoogleTag.prototype.isInitialized = function () {
		log(['isInitialized', this.initialized], 'debug', logGroup);
		return this.initialized;
	};

	GoogleTag.prototype.setPageLevelParams = function (params) {
		this.push(function () {
			var name,
				pubAds = window.googletag.pubads(),
				value;

			pageLevelParams = params;
			for (name in pageLevelParams) {
				if (pageLevelParams.hasOwnProperty(name)) {
					value = pageLevelParams[name];
					if (value) {
						log(['setPageLevelParams', 'pubAds.setTargeting', name, value], 'debug', logGroup);
						pubAds.setTargeting(name, value);
					}
				}
			}
		});
	};

	GoogleTag.prototype.push = function (callback) {
		window.googletag.cmd.push(callback);
		if (!helper.isBlocking()) {
			recoveryCmd.push(callback);
		}
	};

	GoogleTag.prototype.flush = function () {
		if (!this.isInitialized()) {
			log(['flush', 'done', 'No slots to flush'], 'info', logGroup);
			return;
		}

		this.push(function () {
			log(['flush', 'start'], 'info', logGroup);

			log(['flush', 'refresh', slotQueue], 'debug', logGroup);
			if (slotQueue.length) {
				window.googletag.pubads().refresh(slotQueue, {changeCorrelator: false});
				slotQueue = [];
			}

			log(['flush', 'done'], 'info', logGroup);
		});
	};

	GoogleTag.prototype.addSlot = function (adElement) {
		var sizes = adElement.getSizes(),
			slot = slots[adElement.getId()];

		log(['addSlot', adElement], 'debug', logGroup);

		adElement.setPageLevelParams(pageLevelParams);
		if (!slot) {
			if (sizes) {
				slot = window.googletag.defineSlot(adElement.getSlotPath(), sizes, adElement.getId());
			} else {
				slot = window.googletag.defineOutOfPageSlot(adElement.getSlotPath(), adElement.getId());
			}
			slot.addService(window.googletag.pubads());
			window.googletag.display(adElement.getId());
			slots[adElement.getId()] = slot;
		}

		adElement.configureSlot(slot);
		slotQueue.push(slot);

		return slot;
	};

	GoogleTag.prototype.registerCallback = function (id, callback) {
		log(['registerCallback', id], 'info', logGroup);
		registeredCallbacks[id] = callback;
	};

	GoogleTag.prototype.onAdLoad = function (slotName, element, gptEvent, onAdLoadCallback) {
		log(['onAdLoad', slotName], 'info', logGroup);
		var iframe = element.getNode().querySelector('div[id*="_container_"] iframe');

		onAdLoadCallback(element.getId(), gptEvent, iframe);
	};

	GoogleTag.prototype.reset = function () {
		if (this.initialized) {
			return;
		}

		this.push(function () {
			window.googletag.destroySlots();
		});

		this.initialized = false;
		window.googletag = {};
		window.googletag.cmd = recoveryCmd;
	};

	return GoogleTag;
});
