var AdProviderNull = function(log) {
	var module = 'AdProviderNull'
		, canHandleSlot
		, fillInSlot;

	canHandleSlot = function(slot) {
		return true;
	};

	fillInSlot = function(slot) {
		log('fillInSlot', 5, module);
		log(slot, 7, module);
		return;
	};

	return {
		name: 'Null',
		canHandleSlot: canHandleSlot,
		fillInSlot: fillInSlot
	};
};
