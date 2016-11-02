/*global define*/
define('ext.wikia.adEngine.slot.highImpact', [
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.window'
], function (slotsContext, win) {
	'use strict';

	var slotName = 'INVISIBLE_HIGH_IMPACT_2';

	function init() {
		if (slotsContext.isApplicable(slotName)) {
			win.adslots2.push({
				slotName: slotName
			});
		}
	}

	return {
		init: init
	};
});
