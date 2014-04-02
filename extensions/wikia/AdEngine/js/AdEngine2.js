/*global define*/
define('ext.wikia.adEngine.adEngine', [
	'wikia.log',
	'wikia.lazyqueue',
	'ext.wikia.adEngine.slotTracker'
], function (log, LazyQueue, slotTracker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adEngine',
		undef;

	function decorate(func, decorators) {
		log(['decorate', func, decorators], 'debug', logGroup);

		var i, len;

		if (decorators && decorators.length) {
			for (i = 0, len = decorators.length; i < len; i += 1) {
				func = decorators[i](func);
			}
		}

		return func;
	}

	function run(adConfig, adslots, queueName) {
		var decorators = adConfig.getDecorators();

		function fillInSlot(slot) {
			log(['fillInSlot', slot], 'debug', logGroup);

			var slotname = slot[0],
				provider = adConfig.getProvider(slot),
				aSlotTracker = slotTracker(provider.name, slotname, queueName);

			function success(extra) {
				log(['success', slotname, extra], 'debug', logGroup);
				aSlotTracker.track('success');
			}

			function hop(extra, hopTo) {
				log(['hop', slotname, extra, hopTo], 'debug', logGroup);
				aSlotTracker.track('hop', extra);
				if (hopTo) {
					adslots.push([slotname, undef, hopTo]);
				}
			}

			log('calling ' + provider.name + '.fillInSlot for ' + slotname, 'debug', logGroup);

			provider.fillInSlot(slotname, success, hop);
		}

		log('run', 'debug', logGroup);

		log('initial queue', 'debug', logGroup);
		log(adslots, 'debug', logGroup);

		log('initializing LazyQueue on the queue', 7, logGroup);
		LazyQueue.makeQueue(adslots, decorate(fillInSlot, decorators));

		log('launching queue on adslots', 'debug', logGroup);
		adslots.start();

		log('initial queue handled', 'debug', logGroup);
	}

	return {run: run};
});
