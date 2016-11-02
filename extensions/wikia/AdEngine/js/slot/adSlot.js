/*global define, require*/
define('ext.wikia.adEngine.slot.adSlot', [
	'wikia.document',
	'wikia.window',
	require.optional('ext.wikia.aRecoveryEngine.recovery.helper')
], function (doc, win, recoveryHelper) {
	'use strict';

	function create(name, container, callbacks) {
		var slot = {
			name: name,
			container: container
		};

		slot.success = function (adInfo) {
			if (typeof callbacks.success === 'function') {
				callbacks.success(adInfo);
			}
		};
		slot.collapse = function (adInfo) {
			if (typeof callbacks.collapse === 'function') {
				callbacks.collapse(adInfo);
			}
		};
		slot.hop = function (adInfo) {
			if (typeof callbacks.hop === 'function') {
				callbacks.hop(adInfo);
			}
		};

		return slot;
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
