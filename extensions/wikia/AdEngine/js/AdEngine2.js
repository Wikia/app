var AdEngine2 = function(AdConfig2, log, LazyQueue) {
	'use strict';

	var module = 'AdEngine2'
		, fillInSlot
		, run;

	fillInSlot = function(slot) {
		log('fillInSlot', 5, module);
		log(slot, 5, module);

		var provider = AdConfig2.getProvider(slot);
		log('calling ' + provider.name + ' for ' + slot[0], 3, module);

		provider.fillInSlot(slot);
	};

	run = function(adslots) {
		log('run', 5, module);

		log('initial queue', 7, module);
		log(adslots, 7, module);

		log('initializing LazyQueue on adslots', 7, module);
		LazyQueue.makeQueue(adslots, fillInSlot);

		log('launching queue on adslots', 7, module);
		adslots.start();

		log('initial queue handled', 6, module);
	};

	return {run: run};
};
