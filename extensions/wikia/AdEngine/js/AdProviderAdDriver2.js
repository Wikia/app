window.AdProviderAdDriver2 = function (log, window) {
	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderAdDriver2');
		log(slot, 5, 'AdProviderAdDriver2');

		if(!window.adslots) {
			window.adslots = [];
		}
		window.adslots.push([slot[0], slot[1], 'DART', slot[3]]);
		//if (window.wgLoadAdDriverOnLiftiumInit || true /*(window.getTreatmentGroup && (getTreatmentGroup(EXP_AD_LOAD_TIMING) == TG_AS_WRAPPERS_ARE_RENDERED))*/) {
			/*if (window.adDriverCanInit) {
				log('calling AdDriverDelayedLoader.prepareSlots', 7, 'AdProviderAdDriver2');
				window.AdDriverDelayedLoader.prepareSlots(window.AdDriverDelayedLoader.highLoadPriorityFloor);
			}
		}*/
	}

	return {
		name: 'AdDriver2',
		fillInSlot: fillInSlot
	};
};
