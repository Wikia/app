/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.sourcePointTag', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.sourcePoint',
	'ext.wikia.adEngine.utils.cssTweaker',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, GoogleTag, adSlot, sourcePoint, cssTweaker, doc, log, window) {
	'use strict';

	var blocking = false,
		context = adContext.getContext(),
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
		gads.src = context.opts.sourcePointUrl;
		gads.setAttribute('data-client-id', sourcePoint.getClientId());

		gads.addEventListener('load', function () {
			var spReadyEvent = new window.Event('sp.ready');
			window.dispatchEvent(spReadyEvent);
		});

		doc.addEventListener('sp.blocking', (function () {
			log(['sp.blocking'], 'debug', logGroup);
			doc.body.classList.add('source-point');
			blocking = true;
		}).bind(this));

		doc.addEventListener('sp.not_blocking', (function () {
			log(['sp.not_blocking'], 'debug', logGroup);
		}).bind(this));

		log('Appending GPT script to head', 'debug', logGroup);
		node.parentNode.insertBefore(gads, node);

		this.enableServices();

		this.initialized = true;
	};

	SourcePointTag.prototype.addSlot = function (adElement) {
		log(['adSlot', adElement], 'debug', logGroup);
		var slot = GoogleTag.prototype.addSlot.call(this, adElement),
			spBlockValue = slot.getTargeting('sp.block');

		if (spBlockValue && spBlockValue.length && spBlockValue[0] === '1') {
			log(['addSlot', 'blocked', adElement.getId()], 'debug', logGroup);
			slot.setCollapseEmptyDiv(true, true);
		}

		return slot;
	};

	SourcePointTag.prototype.onAdLoad = function (slotName, element, gptEvent, onAdLoadCallback) {
		log(['onAdLoad', slotName], 'debug', logGroup);
		var iframe,
			newSlotName,
			slotElementId;

		if (blocking && gptEvent.slot && gptEvent.slot.getSlotElementId) {
			slotElementId = gptEvent.slot.getSlotElementId() || element.getId();
			newSlotName = adSlot.getShortSlotName(slotElementId);

			if (slotName !== newSlotName) {
				cssTweaker.copyStyles(slotName, newSlotName);

				iframe = doc.getElementById(slotElementId).querySelector('div[id*="_container_"] iframe');
				iframe.addEventListener('load', function () {
					onAdLoadCallback(slotElementId, gptEvent, iframe);
				});
				return;
			}
		}

		GoogleTag.prototype.onAdLoad.call(this, slotName, element, gptEvent, onAdLoadCallback);
	};

	return SourcePointTag;
});
