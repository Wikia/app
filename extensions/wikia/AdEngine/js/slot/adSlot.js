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
			return function(adInfo) {
				if (typeof callbacks[name] ===  'function') {
					callbacks[name](adInfo);
				}
			}
		}

		return {
			name: name,
			container: container,
			collapse: registerHook('collapse'),
			hop: registerHook('hop'),
			renderEnded: registerHook('renderEnded'),
			success: registerHook('success')
		}
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

	return {
		create: create,
		getIframe: getIframe,
		getShortSlotName: getShortSlotName
	};
});
