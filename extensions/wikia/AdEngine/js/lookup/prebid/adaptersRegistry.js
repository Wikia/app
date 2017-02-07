define('ext.wikia.adEngine.lookup.prebid.adaptersRegistry', [
	'ext.wikia.adEngine.lookup.prebid.adapters.aol',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexus',
	'ext.wikia.adEngine.lookup.prebid.adapters.indexExchange'
], function(aol, appnexus, index) {
	'use strict';

	var adapters = [
		appnexus,
		index,
		aol
	];

	function getAdapters() {
		return adapters;
	}

	function push(adapter) {
		adapters.push(adapter);
	}

	return {
		getAdapters: getAdapters,
		push: push
	}
});
