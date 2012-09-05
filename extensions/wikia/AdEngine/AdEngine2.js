var AdEngine2 = {
	log:function (msg, level, obj) {
		Wikia.log(msg, level, 'AdEngine2');

		if (typeof obj != 'undefined') {
			Wikia.log(obj, level, 'AdEngine2');
		}
	},

	init:function () {
		this.log('init', 5);

		this.moveQueue();
	},

	fillInSlot:function (slot) {
		this.log('fillInSlot', 5, slot);

		var provider = AdConfig2.getProvider(slot);
		this.log('calling ' + provider + ' for ' + slot[0], 3);
		slot[2] = provider;
		window['adProvider' + provider].fillInSlot(slot);
	},

	// based on WikiaTrackerQueue by macbre
	moveQueue:function () {
		this.log('moveQueue', 5);

		var slots = window.adslots2 || [], slot;
		this.log('queue', 7, slots);
		while ((slot = slots.shift()) !== undefined) {
			this.fillInSlot(slot);
		}

		slots.push = this.proxy(this.fillInSlot, this);
		this.log('queue moved', 6);
	},

	proxy:function (fn, scope) {
		return function () {
			return fn.apply(scope, arguments);
		}
	}
};