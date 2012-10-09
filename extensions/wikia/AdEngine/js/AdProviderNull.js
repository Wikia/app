var AdProviderNull = function(log, slotTweaker) {
	var module = 'AdProviderNull'
		, canHandleSlot
		, fillInSlot;

	canHandleSlot = function(slot) {
		return true;
	};

	fillInSlot = function(slot) {
		var slotname = slot[0];
		log('fillInSlot', 5, module);
		log(slot, 7, module);
		slotTweaker.hide(slotname);
		return;
	};

	return {
		name: 'Null',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};
