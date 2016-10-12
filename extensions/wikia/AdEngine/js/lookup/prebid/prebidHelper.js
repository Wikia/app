/*global define*/
define('ext.wikia.adEngine.lookup.prebid.prebidHelper', [], function() {
	'use strict';
	var adUnits = [];

	function getAdapterAdUnits(adapter, skin) {
		var adapterAdUnits = [],
			slots = adapter.getSlots(skin);

		Object.keys(slots).forEach(function(slotName) {
			adapterAdUnits.push(adapter.prepareAdUnit(slotName, slots[slotName], skin));
		});

		return adapterAdUnits;
	}

	function addAdUnits(adapterAdUnits) {
		adapterAdUnits.forEach(function (adUnit) {
			adUnits.push(adUnit);
		});
	}

	function setupAdUnits(adapters, skin) {
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
