/*global define*/
define('ext.wikia.adEngine.slot.adSlot', [
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'wikia.document',
	'wikia.log'
], function (adUnitBuilder, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.adSlot';

	function create(name, container, callbacks) {

		function registerHook(name) {
			return function (adInfo) {
				if (typeof callbacks[name] === 'function') {
					return callbacks[name](adInfo);
				}
			};
		}

		return {
			name: name,
			container: container,
			isViewedFlag: false,
			isViewed: function () {
				return this.isViewedFlag;
			},
			enabled: true,
			isEnabled: registerHook('isEnabled'),
			disable: registerHook('disable'),
			enable: registerHook('enable'),
			collapse: registerHook('collapse'),
			hop: registerHook('hop'),
			loaded: registerHook('loaded'),
			renderEnded: registerHook('renderEnded'),
			success: registerHook('success'),
			viewed: registerHook('viewed')
		};
	}

	function getShortSlotName(slotName) {
		return adUnitBuilder.getShortSlotName(slotName);
	}

	function getIframe(slotName) {
		var cssSelector = '#' + slotName + ' > .provider-container:not(.hidden) div[id*="_container_"] > iframe',
			iframe = doc.querySelector(cssSelector);

		log(['getIframe', slotName, iframe && iframe.id], log.levels.debug, logGroup);

		return iframe;
	}

	function getProviderContainer(slotName) {
		var slotContainer = doc.getElementById(slotName);

		if (slotContainer) {
			return slotContainer.lastElementChild || null;
		}

		return null;
	}

	return {
		create: create,
		getIframe: getIframe,
		getProviderContainer: getProviderContainer,
		getShortSlotName: getShortSlotName
	};
});
