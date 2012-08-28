var Ad = Ad || {};

Ad.Loader = (function (Util, Logic, window, console, undef) {
	'use strict';

	var fillInSlot = function (slot) {
			Util.log('Ad.Loader:fillInSlot', slot);

			var provider = Logic.getProviderForSlot(slot[0]);
			Util.log(provider.name);

			//slot[2] = provider;
			provider.fillInSlot(slot);
		},
		loadAds = function () {
			var slot;

			Util.log('init');
			Util.log('Current slot queue:', window.adslots2);
			do {
				slot = window.adslots2.shift();
				if (slot) {
					fillInSlot(slot);
				}
			} while (slot);

			window.adslots2.push = fillInSlot;
		};

	return { loadAds: loadAds };

}(Ad.Util, Ad.Logic, window, window.console));

// TODO: move this elsewhere
if (!window.wgInsideUnitTest) {
	Ad.Loader.loadAds();
}

// TODO: use something else than window.adslots2
