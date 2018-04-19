/*global define*/
define('ext.wikia.adEngine.lookup.prebid.prebidHelper', [
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery'
], function(adaptersRegistry, instartLogic) {
	'use strict';
	var adUnits = [],
		lazyLoad = 'off',
		lazyLoadSlots = [
			'BOTTOM_LEADERBOARD'
		];

	function getAdapterAdUnits(adapter, skin) {
		var adapterAdUnits = [],
			isRecovering = instartLogic.isBlocking(),
			slots = adapter.getSlots(skin, isRecovering);

		Object.keys(slots).forEach(function(slotName) {
			var adUnit = adapter.prepareAdUnit(slotName, slots[slotName], skin, isRecovering);
			if (adUnit) {
				adapterAdUnits.push(adUnit);
			}
		});

		return adapterAdUnits;
	}

	function addAdUnits(adapterAdUnits) {
		adapterAdUnits.forEach(function (adUnit) {
			if (lazyLoad === 'off' ||
				(lazyLoad === 'pre' && lazyLoadSlots.indexOf(adUnit.code) === -1) ||
				(lazyLoad === 'post' && lazyLoadSlots.indexOf(adUnit.code) !== -1)) {
				adUnits.push(adUnit);
			}
		});
	}

	function setupAdUnits(skin, mode) {
		var adapters = adaptersRegistry.getAdapters();

		lazyLoad = mode ? mode : lazyLoad;
		adUnits = [];
		adapters.forEach(function (adapter) {
			if (adapter && adapter.isEnabled()) {
				addAdUnits(getAdapterAdUnits(adapter, skin));
			}
		});

		return adUnits;
	}

	return {
		setupAdUnits: setupAdUnits
	};
});
