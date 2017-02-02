/*global define, require*/
define('ext.wikia.adEngine.slot.adSlot', [
	'wikia.document',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.helper')
], function (doc, log, win, recoveryHelper) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.adSlot';

	function create(name, container, callbacks) {

		function registerHook(name) {
			return function (adInfo) {
				if (typeof callbacks[name] === 'function') {
					callbacks[name](adInfo);
				}
			};
		}

		return {
			name: name,
			container: container,
			collapse: registerHook('collapse'),
			hop: registerHook('hop'),
			renderEnded: registerHook('renderEnded'),
			success: registerHook('success')
		};
	}

	function getShortSlotName(slotName) {
		return slotName.replace(/^.*\/([^\/]*)$/, '$1');
	}

	function getRecoveredIframe(slotName) {
		var node = doc.querySelector('#' + slotName + ' > .provider-container:not(.hidden) > div'),
			fallbackId = node && win._sp_.getElementId(node.id),
			elementById = fallbackId && doc.getElementById(fallbackId);

		if (elementById) {
			return elementById.querySelector('div[id*="_container_"] iframe');
		}
	}

	function getIframe(slotName) {
		var cssSelector = '#' + slotName + ' > .provider-container:not(.hidden) div[id*="_container_"] > iframe',
			iframe = doc.querySelector(cssSelector);

		if (!iframe && recoveryHelper && recoveryHelper.isRecoveryEnabled() && recoveryHelper.isBlocking()) {
			iframe = getRecoveredIframe(slotName);
		}

		log(['getIframe', slotName, iframe && iframe.id], log.levels.debug, logGroup);

		return iframe;
	}

	function getRecoveredProviderContainer(providerContainer) {
		var elementId = providerContainer.childNodes.length > 0 && providerContainer.childNodes[0].id,
			recoveredElementId = win._sp_.getElementId(elementId),
			element = doc.getElementById(recoveredElementId);

		log(['getRecoveredProviderContainer for container', providerContainer], log.levels.debug, logGroup);
		log(['getRecoveredProviderContainer recovered element ID', recoveredElementId], log.levels.debug, logGroup);
		log(['getRecoveredProviderContainer recovered element', element], log.levels.debug, logGroup);

		if (element && element.parentNode) {
			log(['getRecoveredProviderContainer recovered provider container', element.parentNode], log.levels.debug, logGroup);
			return element.parentNode;
		}

		return null;
	}

	function getProviderContainer(slotName) {
		var isRecovering = recoveryHelper.isRecoveryEnabled() && recoveryHelper.isBlocking(),
			providerContainer,
			slotContainer = doc.getElementById(slotName);

		providerContainer = slotContainer.lastElementChild;
		if (isRecovering && providerContainer.hasAttribute('data-sp-clone')) {
			providerContainer = getRecoveredProviderContainer(providerContainer);
		}

		return providerContainer;
	}

	return {
		create: create,
		getIframe: getIframe,
		getProviderContainer: getProviderContainer,
		getShortSlotName: getShortSlotName
	};
});
