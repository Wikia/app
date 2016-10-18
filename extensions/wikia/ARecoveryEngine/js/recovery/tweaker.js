/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.tweaker', [
	'ext.wikia.adEngine.domElementTweaker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.browserDetect',
	'wikia.document',
	'wikia.log'
], function (
	DOMElementTweaker,
	slotTweaker,
	recoveryHelper,
	browser,
	doc,
	log
) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.tweaker';

	function isNotSupportedBrowser() {
		return browser.isIE() || browser.isEdge();
	}

	function mirrorDOMStructure(parentNode) {
		var div = doc.createElement('div'),
			originalIframe = doc.createElement('iframe');

		div.appendChild(originalIframe);
		parentNode.appendChild(div);
		originalIframe.style.display = 'none';
		div.style.display = 'none';

		return originalIframe;
	}

	function tweakSlot(slotName, iframe) {
		var adContainer = iframe.parentNode.parentNode.parentNode.parentNode,
			originalIframe = mirrorDOMStructure(doc.querySelector('#' + slotName + ' > div > div'));

		if (isNotSupportedBrowser()) {
			DOMElementTweaker.hide(adContainer, true);
			log(['tweakSlot', 'not supported browser'], 'info', logGroup);
			return;
		}

		slotTweaker.tweakRecoveredSlot(originalIframe, iframe);
		log(['tweakSlot', slotName], 'info', logGroup);
	}

	function isTweakable() {
		return recoveryHelper.isRecoveryEnabled() && recoveryHelper.isBlocking();
	}

	return {
		isTweakable: isTweakable,
		tweakSlot: tweakSlot
	};
});
