/*global define,setTimeout*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.googleTag', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, window) {

	var logGroup = 'ext.wikia.adEngine.provider.gpt.googleTag',
		initialized = false,
		registeredCallbacks = {},
		slots = {},
		slotQueue = [],
		googleTag,
		pubAds;

	function init() {
		log('init', 'debug', logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		window.googletag = window.googletag || {};
		window.googletag.cmd = window.googletag.cmd || [];

		gads.async = true;
		gads.type = 'text/javascript';
		gads.src = '//www.googletagservices.com/tag/js/gpt.js';

		log('Appending GPT script to head', 'debug', logGroup);

		node.parentNode.insertBefore(gads, node);
		googleTag = window.googletag;

		// Enable services
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
		initialized = true;
	}

	function isInitialized() {
		return initialized;
	}

	function push(callback) {
		googleTag.cmd.push(callback);
	}

	function flush() {
		if (!isInitialized()) {
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
	}

	function addSlot(slotName, slotPath, slotTargeting, element) {
		var slot = slots[element.getId()];

		log(['addSlot', slotName, slotPath, slotTargeting, element], 'debug', logGroup);

		element.setPageLevelParams(pubAds);
		if (!slot) {
			element.setSizes(slotName, slotTargeting.size);

			slot = googleTag.defineSlot(slotPath, element.getSizes(), element.getId());
			slot.addService(pubAds);
			element.setSlotLevelParams(slot, slotTargeting);

			googleTag.display(element.getId());

			slots[element.getId()] = slot;
		}

		slotQueue.push(slot);
	}

	function registerCallback(id, callback) {
		log(['registerCallback', id], 'info', logGroup);
		registeredCallbacks[id] = callback;
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

	return {
		init: init,
		isInitialized: isInitialized,
		push: push,
		flush: flush,
		addSlot: addSlot,
		registerCallback: registerCallback
	};
});
