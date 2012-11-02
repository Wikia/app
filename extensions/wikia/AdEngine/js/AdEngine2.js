var AdEngine2 = function(log, LazyQueue) {
	'use strict';

	var module = 'AdEngine2'
		, run;

	run = function(adConfig, adslots) {
		log('run', 5, module);

		log('initial queue', 7, module);
		log(adslots, 7, module);

		log('initializing LazyQueue on the queue', 7, module);
		LazyQueue.makeQueue(adslots, function(slot) {
			log('fillInSlot', 5, module);
			log(slot, 5, module);

			var slotname = slot[0]
				, provider = adConfig.getProvider(slot)
			;

			log('calling ' + provider.name + '.fillInSlot for ' + slotname, 3, module);

			provider.fillInSlot([slotname]);
		});

		log('launching queue on adslots', 7, module);
		adslots.start();

		log('initial queue handled', 6, module);
	};

	return {run: run};
};
