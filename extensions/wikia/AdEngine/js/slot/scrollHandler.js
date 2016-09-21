/*global define*/
define('ext.wikia.adEngine.slot.scrollHandler', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adHelper',
	'ext.wikia.adEngine.utils.domCalculator',
	'wikia.log',
	'wikia.document',
	'wikia.window'
], function (adContext, adHelper, dom, log, doc, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.slot.scrollHandler',
		isRefreshed = {},
		reloadedView = {},
		context = adContext.getContext(),
		config = context.opts.scrollHandlerConfig || {},
		skin;

	function init(currentSkin) {
		skin = currentSkin;
		if (context.opts.enableScrollHandler)  {
			config = config[skin];
			prepareSettings();
			registerSlotEvents();
		}
	}

	function prepareSettings() {
		for (var slotName in config) {
			if (config.hasOwnProperty(slotName)) {
				isRefreshed[slotName] = false;
				reloadedView[slotName] = 0;
			}
		}
	}

	function registerSlotEvents() {
		win.addEventListener('scroll', adHelper.throttle(function () {
			log('Scroll event listener has been added', 'debug', logGroup);
			for (var slotName in config) {
				if (config.hasOwnProperty(slotName)) {
					if (config[slotName].trigger.match(/^scroll\.(top|bottom)$/) === null) {
						continue;
					}
					onScroll(slotName);
				}
			}
		}));
	}

	function refreshSlot(slotName) {
		reloadedView[slotName] += 1;
		if (skin === 'oasis') {
			win.adslots2.push([slotName]);
		} else if (skin === 'mercury') {
			win.Mercury.Modules.Ads.getInstance().pushSlotToQueue(slotName);
		}
	}

	function onScroll(slotName) {
		if (config[slotName].hasOwnProperty('reloadedViewMax') &&
			config[slotName].reloadedViewMax >= 0 &&
			config[slotName].reloadedViewMax <= reloadedView[slotName]) {
			return;
		}

		var status = isReached(slotName);
		if (!isRefreshed[slotName] && status) {
			log(['refreshSlot', slotName + ' has been refreshed'], 'debug', logGroup);
			refreshSlot(slotName);
			isRefreshed[slotName] = true;
		} else if (!status) {
			isRefreshed[slotName] = false;
		}
	}

	function isReached(slotName) {
		var el = doc.getElementById(slotName),
			offset = 0;

		if (!el) {
			return false;
		}

		if (config[slotName].trigger === 'scroll.bottom') {
			offset = el.offsetHeight;
		}

		return win.innerHeight + win.scrollY >= dom.getTopOffset(el) + offset;
	}

	function getReloadedViewCount(slotName) {
		if (reloadedView.hasOwnProperty(slotName)) {
			return reloadedView[slotName];
		}

		return null;
	}

	adContext.addCallback(function () {
		prepareSettings();
	});

	return {
		init: init,
		getReloadedViewCount: getReloadedViewCount
	};
});
