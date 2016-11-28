/*global define, require*/
define('ext.wikia.adEngine.slot.adSlot', [
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.helper')
], function (doc, win, recoveryHelper) {
	'use strict';

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
		var node = doc.querySelector('#' + slotName + ' > div > div'),
			fallbackId = node && win._sp_.getElementId(node.id),
			elementById = fallbackId && doc.getElementById(fallbackId);

		if (elementById) {
			return elementById.querySelector('div:not(.hidden) > div[id*="_container_"] iframe');
		}
	}

	function getIframe(slotName) {
		var iframe = doc.querySelector('#' + slotName +' div:not(.hidden) > div[id*="_container_"] iframe');

		if (!iframe && recoveryHelper && recoveryHelper.isRecoveryEnabled() && recoveryHelper.isBlocking()) {
			iframe = getRecoveredIframe(slotName);
		}

		return iframe;
	}

	return {
		create: create,
		getIframe: getIframe,
		getShortSlotName: getShortSlotName
	};
});
