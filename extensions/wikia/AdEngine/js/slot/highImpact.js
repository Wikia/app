/*global define*/
define('ext.wikia.adEngine.slot.highImpact', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slotTweaker',
	'wikia.window'
], function (adContext, slotTweaker, win) {
	'use strict';

	var context = adContext.getContext(),
		slotName = 'INVISIBLE_HIGH_IMPACT_2';

	function init() {
		if (context.slots.invisibleHighImpact2) {
			win.adslots2.push({
				slotName: slotName
			});
		}
	}

	return {
		init: init
	};
});
