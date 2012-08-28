var AdProviderAdEngine2 = my.Class({
	// core stuff, should be overwritten
	name:'AdProviderAdEngine2 (error, this should be overwritten)',

	fillInSlot:function (slot) {
		this.log('fillInSlot', slot);

		this.log('error, this should be overwritten');
	},

	// private stuff
	// none

	// helpers, should be inherited
	debug:true,

	log:function (msg, obj) {
		if (typeof console == 'undefined') return;

		// FIXME WikiaLogger...
		if (!this.debug) return;

		console.log(this.name + ': ' + msg);
		if (typeof obj != 'undefined') {
			console.log(obj);
		}
	}
});