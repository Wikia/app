window.AdProviderLater = function(log, adslots_later) {
	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderLater');
		log(slot, 5, 'AdProviderLater');

		adslots_later.push(slot);
	}

	var iface = {
		name: 'Later',
		fillInSlot: fillInSlot
	};

	return iface;

};