window.AdEngine2 = window.AdEngine2 || (function (AdConfig2, log, window) {
	function init() {
		log('init', 5, 'AdEngine2');

		moveQueue();
	}

	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdEngine2');
		log(slot, 5, 'AdEngine2');

		var provider = AdConfig2.getProvider(slot);
		log('calling ' + provider.name + ' for ' + slot[0], 3, 'AdEngine2');

		slot[2] = provider.name;
		provider.fillInSlot(slot);
	}

	// based on WikiaTrackerQueue by macbre
	function moveQueue() {
		log('moveQueue', 5, 'AdEngine2');

		var slots = window.adslots2 || [], slot;
		log('queue', 7, 'AdEngine2');
		log(slots, 7, 'AdEngine2');
		while ((slot = slots.shift()) !== undefined) {
			fillInSlot(slot);
		}

		slots.push = proxy(fillInSlot, this);
		log('queue moved', 6, 'AdEngine2');
	}

	function proxy(fn, scope) {
		return function () {
			return fn.apply(scope, arguments);
		}
	}

	return {init: init};

}(AdConfig2, Wikia.log, window));