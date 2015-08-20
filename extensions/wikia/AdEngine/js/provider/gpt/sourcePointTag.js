/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.sourcePointTag', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (adContext, adTracker, GoogleTag, doc, log, window) {
	'use strict';

	var blocking = false,
		cmdQueue = [],
		context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.provider.gpt.sourcePointTag',
		ready = false,
		sourcePointClientId = 'rMbenHBwnMyAMhR';

	/**
	 * Create cssText based on computedStyle
	 * Custom method because of Firefox bug #137687
	 */
	function getComputedStyleCssText(element) {
		var style = window.getComputedStyle(element),
			cssText;

		if (style.cssText !== '') {
			return style.cssText;
		}

		cssText = '';
		for (var i = 0; i < style.length; i++) {
			cssText += style[i] + ':' + style.getPropertyValue(style[i]) + ';';
		}

		return cssText;
	}

	function copyStyles(from, to) {
		log(['copyStyles', from, to], 'debug', logGroup);
		var source = doc.getElementById(from),
			destination = doc.getElementById(to);

		if (destination) {
			destination.style.cssText = getComputedStyleCssText(source);
		}
	}

	function SourcePointTag() {
		GoogleTag.call(this);
	}

	SourcePointTag.prototype = new GoogleTag();

	SourcePointTag.prototype.init = function () {
		log('init', 'debug', logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0],

			pushQueue = function () {
				cmdQueue.forEach((function (callback) {
					GoogleTag.prototype.push.call(this, callback);
				}).bind(this));
				cmdQueue = [];
			};

		gads.async = true;
		gads.type = 'text/javascript';
		gads.src = context.opts.sourcePointUrl;
		gads.setAttribute('data-client-id', sourcePointClientId);

		gads.addEventListener('load', function () {
			var spReadyEvent = new window.Event('sp.ready');
			window.dispatchEvent(spReadyEvent);
		});

		doc.addEventListener('sp.blocking', (function () {
			log(['sp.blocking'], 'debug', logGroup);
			adTracker.track('sourcepoint/blocked');

			doc.body.classList.add('source-point');
			blocking = true;
			pushQueue();
			ready = true;
		}).bind(this));

		doc.addEventListener('sp.not_blocking', (function () {
			log(['sp.not_blocking'], 'debug', logGroup);
			adTracker.track('sourcepoint/not_blocked');

			pushQueue();
			ready = true;
		}).bind(this));

		log('Appending GPT script to head', 'debug', logGroup);
		node.parentNode.insertBefore(gads, node);

		this.enableServices();

		this.initialized = true;
	};

	SourcePointTag.prototype.push = function (callback) {
		log(['push', ready], 'debug', logGroup);
		if (!ready) {
			cmdQueue.push(callback);
		} else {
			GoogleTag.prototype.push.call(this, callback);
		}
	};

	SourcePointTag.prototype.addSlot = function (adElement) {
		log(['adSlot', adElement], 'debug', logGroup);
		var slot = GoogleTag.prototype.addSlot.call(this, adElement);

		if (blocking) {
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
			newSlotName = slotElementId.replace(/(.*)([\/])([^\/]*$)/, '$3');

			if (slotName !== newSlotName) {
				copyStyles(slotName, newSlotName);

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
