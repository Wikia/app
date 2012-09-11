window.AdEngine2 = function (AdConfig2, log, window, undef) {
	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdEngine2');
		log(slot, 5, 'AdEngine2');

		var provider = AdConfig2.getProvider(slot);
		log('calling ' + provider.name + ' for ' + slot[0], 3, 'AdEngine2');

		slot[2] = provider.name;
		provider.fillInSlot(slot);
	}

	// based on WikiaTrackerQueue by macbre
	function run() {
		log('run', 5, 'AdEngine2');

		var slots = window.adslots2 || [], slot;
		log('queue', 7, 'AdEngine2');
		log(slots, 7, 'AdEngine2');
		while ((slot = slots.shift()) !== undef) {
			fillInSlot(slot);
		}

		slots.push = proxy(fillInSlot, this);
		log('initial queue handled', 6, 'AdEngine2');
	}

	function proxy(fn, scope) {
		return function () {
			return fn.apply(scope, arguments);
		}
	}

	return {run: run};

};
