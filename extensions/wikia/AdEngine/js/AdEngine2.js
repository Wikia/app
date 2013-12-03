/*exported AdEngine2*/
var AdEngine2 = function (log, LazyQueue, slotTracker) {
	'use strict';

	var logGroup = 'AdEngine2',
		undef;

	function run(adConfig, adslots, queueName) {

		log('run', 'debug', logGroup);

		log('initial queue', 'debug', logGroup);
		log(adslots, 'debug', logGroup);

		log('initializing LazyQueue on the queue', 7, logGroup);
		LazyQueue.makeQueue(adslots, function (slot) {
			log(['fillInSlot', slot], 'debug', logGroup);

			var slotname = slot[0],
				provider = adConfig.getProvider(slot),
				aSlotTracker = slotTracker(provider.name, slotname, queueName);

			function success(extra) {
				log(['success', slotname, extra], 'debug', logGroup);
				aSlotTracker.track('success');
			}

			function hop(extra, hopTo) {
				log(['hop', slotname, extra], 'debug', logGroup);
				aSlotTracker.track('hop', extra);
				if (hopTo) {
					adslots.push([slotname, undef, hopTo]);
				}
			}

			log('calling ' + provider.name + '.fillInSlot for ' + slotname, 'debug', logGroup);

			provider.fillInSlot(slotname, success, hop);
		});

		log('launching queue on adslots', 'debug', logGroup);
		adslots.start();

		log('initial queue handled', 'debug', logGroup);
	}

	return {run: run};
};
