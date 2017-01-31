define('ext.wikia.adEngine.lookup.prebid.adaptersRegistry', [
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexus',
	'ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork',
	'ext.wikia.adEngine.lookup.prebid.adapters.indexExchange'
], function(appnexus, audienceNetwork, index) {
	'use strict';

	var adapters = [
		appnexus,
		index,
		audienceNetwork
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
