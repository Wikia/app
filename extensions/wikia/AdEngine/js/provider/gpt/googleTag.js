/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.googleTag', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.googleTag',
		registeredCallbacks = {},
		slots = {},
		slotQueue = [],
		pageLevelParams,
		googleTag,
		pubAds;

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
		googleTag = window.googletag = window.googletag || {};
		window.googletag.cmd = window.googletag.cmd || [];

		log(['init', 'googletag.cmd.push'], 'info', logGroup);
		googleTag.cmd.push(function () {
			pubAds = googleTag.pubads();

			pubAds.collapseEmptyDivs();
			pubAds.enableSingleRequest();
			pubAds.disableInitialLoad(); // manually request ads using refresh
			pubAds.addEventListener('slotRenderEnded', dispatchEvent);

			googleTag.enableServices();

			log(['init', 'googletag.cmd.push', 'done'], 'debug', logGroup);
		});
	};

	GoogleTag.prototype.init = function () {
		log('init', 'debug', logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		gads.async = true;
		gads.type = 'text/javascript';
		gads.src = '//www.googletagservices.com/tag/js/gpt.js';

		log('Appending GPT script to head', 'debug', logGroup);
		node.parentNode.insertBefore(gads, node);

		this.enableServices();
		this.initialized = true;
	};

	GoogleTag.prototype.isInitialized = function () {
		return this.initialized;
	};

	GoogleTag.prototype.setPageLevelParams = function (params) {
		googleTag.cmd.push(function () {
			var name,
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
		googleTag.cmd.push(callback);
	};

	GoogleTag.prototype.flush = function () {
		if (!this.isInitialized()) {
			log(['flush', 'done', 'No slots to flush'], 'info', logGroup);
			return;
		}

		googleTag.cmd.push(function () {
			log(['flush', 'start'], 'info', logGroup);

			log(['flush', 'refresh', slotQueue], 'debug', logGroup);
			if (slotQueue.length) {
				pubAds.refresh(slotQueue);
				slotQueue = [];
			}

			log(['flush', 'done'], 'info', logGroup);
		});
	};

	GoogleTag.prototype.addSlot = function (adElement) {
		var slot = slots[adElement.getId()];

		log(['addSlot', adElement], 'debug', logGroup);

		adElement.setPageLevelParams(pageLevelParams);
		if (!slot) {
			slot = googleTag.defineSlot(adElement.getSlotPath(), adElement.getSizes(), adElement.getId());
			slot.addService(pubAds);
			googleTag.display(adElement.getId());
			slots[adElement.getId()] = slot;
		}

		adElement.configureSlot(slot);
		slotQueue.push(slot);
	};

	GoogleTag.prototype.registerCallback = function (id, callback) {
		log(['registerCallback', id], 'info', logGroup);
		registeredCallbacks[id] = callback;
	};

	return GoogleTag;
});
