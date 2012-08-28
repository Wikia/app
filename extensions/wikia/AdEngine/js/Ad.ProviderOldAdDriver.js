var Ad = Ad || {};

// TODO: fix dependency on AdDriverDelayedLoader
Ad.ProviderOldAdDriver = (function (Util, window, undef) {
	'use strict';

	return {
		name: 'Ad.ProviderOldAdDriver',
		fillInSlot: function (slot) {
			Util.log('Ad.ProviderOldAdDriver:fillInSlot', slot);

			if (!window.adslots) {
				window.adslots = [];
			}
			window.adslots.push([slot[0], slot[1], 'DART', slot[3]]);
			if (window.wgLoadAdDriverOnLiftiumInit || true /*(window.getTreatmentGroup && (getTreatmentGroup(EXP_AD_LOAD_TIMING) == TG_AS_WRAPPERS_ARE_RENDERED))*/) {
				if (window.adDriverCanInit) {
					window.AdDriverDelayedLoader.prepareSlots(AdDriverDelayedLoader.highLoadPriorityFloor);
				}
			}
			Util.log('Ad.ProviderOldAdDriver:window.adslots:', window.adslots);
		}
	};
}(Ad.Util, window));
