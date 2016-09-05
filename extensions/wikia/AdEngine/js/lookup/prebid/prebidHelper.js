define('ext.wikia.adEngine.lookup.prebid.prebidHelper', function() {
	var adUnits = [];

	function getAdapterAdUnits(adapter, slots) {
		var getAdapterAdUnits = [];

		Object.keys(slots).forEach(function(slotName) {
			getAdapterAdUnits.push(adapter.prepareAdUnit(slotName, slots[slotName]));
		});

		return getAdapterAdUnits;
	}

	function addAdUnits(adapterAdUnits) {
		adapterAdUnits.forEach(function (adUnit) {
			adUnits.push(adUnit);
		});
	}

	function setupAdUnits(adapters, skin) {
		adapters.forEach(function (adapter) {
			if (adapter && adapter.isEnabled()) {
				addAdUnits(getAdapterAdUnits(adapter, adapter.getSlots(skin)));
			}
		});

		return adUnits;
	}

	return {
		setupAdUnits: setupAdUnits
	};
});
