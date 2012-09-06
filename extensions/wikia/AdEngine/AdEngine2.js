window.AdEngine2 = window.AdEngine2 || (function (Wikia, AdConfig2, window) {
	function log(msg, level, obj) {
		Wikia.log(msg, level, 'AdEngine2');

		if (typeof obj != 'undefined') {
			Wikia.log(obj, level, 'AdEngine2');
		}
	}

	function init() {
		log('init', 5);

		moveQueue();
	}

	function fillInSlot(slot) {
		log('fillInSlot', 5, slot);

		var provider = AdConfig2.getProvider(slot);
		log('calling ' + provider + ' for ' + slot[0], 3);
		slot[2] = provider;
		window['adProvider' + provider].fillInSlot(slot);
	}

	// based on WikiaTrackerQueue by macbre
	function moveQueue() {
		log('moveQueue', 5);

		var slots = window.adslots2 || [], slot;
		log('queue', 7, slots);
		while ((slot = slots.shift()) !== undefined) {
			fillInSlot(slot);
		}

		slots.push = proxy(fillInSlot, this);
		log('queue moved', 6);
	}

	function proxy(fn, scope) {
		return function () {
			return fn.apply(scope, arguments);
		}
	}

	return {init: init};

}(Wikia, AdConfig2, window));