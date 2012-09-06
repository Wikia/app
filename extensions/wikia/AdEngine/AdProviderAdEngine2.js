var AdProviderAdEngine2 = my.Class({
	// core stuff, should be overwritten
	name:'AdProviderAdEngine2',

	fillInSlot:function (slot) {
		this.log('fillInSlot', 5, slot);

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'adengine2'}, 'ga');

		this.log('error, AdProviderAdEngine2.fillInSlot method should be overwritten', 1);
	},

	// private stuff
	// none

	// helpers, should be inherited
	log:function (msg, level, obj) {
		Wikia.log(msg, level, this.name);

		if (typeof obj != 'undefined') {
			Wikia.log(obj, level, this.name);
		}
	}
});