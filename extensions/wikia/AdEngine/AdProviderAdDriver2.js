var AdProviderAdDriver2 = my.Class(AdProviderAdEngine2, {
	// core stuff, should be overwritten
	name:'AdProviderAdDriver2',

	fillInSlot:function (slot) {
		this.log('fillInSlot', slot);

		if(!window.adslots) {
			window.adslots = [];
		}
		window.adslots.push([slot[0], slot[1], 'DART', slot[3]]);
		if (window.wgLoadAdDriverOnLiftiumInit || true /*(window.getTreatmentGroup && (getTreatmentGroup(EXP_AD_LOAD_TIMING) == TG_AS_WRAPPERS_ARE_RENDERED))*/) {
			if (window.adDriverCanInit) {
				AdDriverDelayedLoader.prepareSlots(AdDriverDelayedLoader.highLoadPriorityFloor);
			}
		}
	}

	// private stuff
});

var adProviderAdDriver2 = new AdProviderAdDriver2;