Athena = Athena || (function(Liftium) {
	'use strict';
	var date = new Date();
	return {
		now: date,
		definedInsideWikiajs: true,
		getMinuteTargeting: function () {
			return this.now.getMinutes() % 15;
		},
		getPageVar: Liftium.getPageVar,
		setPageVar: Liftium.setPageVar
	};
}(Liftium));
