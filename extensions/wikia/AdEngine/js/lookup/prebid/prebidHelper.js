/*global define*/
define('ext.wikia.adEngine.lookup.prebid.prebidHelper', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.prebid.adaptersRegistry',
	'ext.wikia.adEngine.lookup.prebid.versionCompatibility',
	'wikia.window'
], function(adContext, adaptersRegistry, prebidVersionCompatibility, win) {
	'use strict';
	var adUnits = [],
		lazyLoad = 'off',
		lazyLoadSlots = [
			'BOTTOM_LEADERBOARD'
		];

	function getAdapterAdUnits(adapter, skin) {
		var adapterAdUnits = [],
			isNewPrebidEnabled = adContext.get('opts.isNewPrebidEnabled'),
			slots = adapter.getSlots(skin);

		Object.keys(slots).forEach(function(slotName) {
			var prepareAdUnit = isNewPrebidEnabled ?
					adapter.prepareAdUnit :
					prebidVersionCompatibility.toVersion0.decoratePrepareAdUnit(adapter.prepareAdUnit),
				adUnit = prepareAdUnit(slotName, slots[slotName], skin);

			if (adUnit) {
				adapterAdUnits.push(adUnit);
			}
		});

		return adapterAdUnits;
	}

	function addAdUnits(adapterAdUnits) {
		adapterAdUnits.forEach(function (adUnit) {
			var isSlotLazy = lazyLoadSlots.indexOf(adUnit.code) !== -1;

			if (lazyLoad === 'off' || (lazyLoad === 'pre' && !isSlotLazy) || (lazyLoad === 'post' && isSlotLazy)) {
				adUnits.push(adUnit);
			}
		});
	}

	function setupAdUnits(skin, mode) {
		var adapters = adaptersRegistry.getAdapters();

		lazyLoad = mode || lazyLoad;
		adUnits = [];
		adapters.forEach(function (adapter) {
			if (adapter && adapter.isEnabled()) {
				addAdUnits(getAdapterAdUnits(adapter, skin));
			}
		});

		return adUnits;
	}

	function isVersion1() {
		var version = (win.pbjs && win.pbjs.version);

		if (!version) {
			throw new Error('Version of prebid not known. Check if library is loaded.');
		}

		return (version.split('.')[0] === 'v1');
	}

	return {
		setupAdUnits: setupAdUnits,
		isVersion1: isVersion1
	};
});
