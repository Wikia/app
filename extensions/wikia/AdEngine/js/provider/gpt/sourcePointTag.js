/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.sourcePointTag', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.sourcePointDetection',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, GoogleTag, adSlot, sourcePoint, doc, log, window) {
	'use strict';

	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.provider.gpt.sourcePointTag';

	function SourcePointTag() {
		GoogleTag.call(this);
	}

	SourcePointTag.prototype = new GoogleTag();

	SourcePointTag.prototype.init = function () {
		log('init', 'debug', logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		gads.async = true;
		gads.type = 'text/javascript';
		gads.src = context.opts.sourcePointRecoveryUrl;
		gads.setAttribute('data-client-id', sourcePoint.getClientId());

		gads.addEventListener('load', function () {
			var spReadyEvent = new window.Event('sp.ready');
			window.dispatchEvent(spReadyEvent);
		});

		// Override previously created googletag object to prevent running stored cmd queue with regular gpt
		window.googletag = {
			cmd: []
		};

		log('Appending GPT script to head', 'debug', logGroup);
		node.parentNode.insertBefore(gads, node);

		this.initialized = true;
		this.enableServices();
	};

	SourcePointTag.prototype.onAdLoad = function (slotName, element, gptEvent, onAdLoadCallback) {
		log(['onAdLoad', slotName], 'debug', logGroup);
		var iframe,
			iframeDoc,
			newSlotName,
			newSlotContainer,
			slotElementId;

		if (gptEvent.slot && gptEvent.slot.getSlotElementId) {
			slotElementId = gptEvent.slot.getSlotElementId() || element.getId();
			newSlotName = adSlot.getShortSlotName(slotElementId);
			newSlotContainer = doc.getElementById(newSlotName);

			if (newSlotContainer) {
				element.setSlotName(newSlotName);
			}

			if (slotName !== newSlotName) {
				element.setSlotContainerId(slotElementId);
				iframe = doc.getElementById(slotElementId).querySelector('div[id*="_container_"] iframe');
				iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

				if (iframeDoc.readyState !== 'complete') {
					iframe.addEventListener('load', function () {
						onAdLoadCallback(slotElementId, gptEvent, iframe);
					});
				} else {
					onAdLoadCallback(slotElementId, gptEvent, iframe);
				}
				return;
			}
		}

		GoogleTag.prototype.onAdLoad.call(this, slotName, element, gptEvent, onAdLoadCallback);
	};

	return SourcePointTag;
});
