window.AdProviderAdDriver = function (log, window) {
	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderAdDriver');
		log(slot, 5, 'AdProviderAdDriver');

		if(!window.adslots) {
			window.adslots = [];
		}
		window.adslots.push([slot[0], slot[1], 'DART', slot[3]]);
		//if (window.wgLoadAdDriverOnLiftiumInit || true /*(window.getTreatmentGroup && (getTreatmentGroup(EXP_AD_LOAD_TIMING) == TG_AS_WRAPPERS_ARE_RENDERED))*/) {
			/*if (window.adDriverCanInit) {
				log('calling AdDriverDelayedLoader.prepareSlots', 5, 'AdProviderAdDriver');
				window.AdDriverDelayedLoader.prepareSlots(window.AdDriverDelayedLoader.highLoadPriorityFloor);
			}
		}*/
	}

	return {
		name: 'AdDriver',
		fillInSlot: fillInSlot
	};
};
