var AdEngine2 = function(AdConfig2, log, LazyQueue) {
	'use strict';

	var MODULE = 'AdEngine2'
		, fillInSlot
		, run;

	fillInSlot = function(slot) {
		log('fillInSlot', 5, MODULE);
		log(slot, 5, MODULE);

		var provider = AdConfig2.getProvider(slot);
		log('calling ' + provider.name + ' for ' + slot[0], 3, MODULE);

		provider.fillInSlot(slot);
	};

	run = function(adslots) {
		log('run', 5, MODULE);

		log('initial queue', 7, MODULE);
		log(adslots, 7, MODULE);

		log('initializing LazyQueue on adslots', 7, MODULE);
		LazyQueue.makeQueue(adslots, fillInSlot);

		log('launching queue on adslots', 7, MODULE);
		adslots.start();

		log('initial queue handled', 6, MODULE);
	};

	return {run: run};
};
