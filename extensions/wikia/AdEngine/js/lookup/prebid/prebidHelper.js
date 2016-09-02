define('ext.wikia.adEngine.lookup.prebid.prebidHelper', function() {
	var adUnits = [];

	function getAdUnits(adapter, slots) {
		var adaptersAdUnits = [];

		Object.keys(slots).forEach(function(slotName) {
			adaptersAdUnits.push(adapter.prepareAdUnit(slotName, slots[slotName]));
		});

		return adaptersAdUnits;
	}

	function addAdUnits(adapterAdUnits) {
		adapterAdUnits.forEach(function (adUnit) {
			adUnits.push(adUnit);
		});
	}

	function setupAdUnits(adapters, skin) {
		adapters.forEach(function (adapter) {
			if (adapter && adapter.isEnabled()) {
				addAdUnits(getAdUnits(adapter, adapter.getSlots(skin)));
			}
		});

		return adUnits;
	}

	return {
		getAdUnits: getAdUnits,
		setupAdUnits: setupAdUnits
	}
});
