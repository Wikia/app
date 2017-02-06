/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adaptersRegistry', [
	'ext.wikia.adEngine.lookup.prebid.adapters.aol',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexus',
	'ext.wikia.adEngine.lookup.prebid.adapters.indexExchange',
	'ext.wikia.adEngine.lookup.prebid.adapters.wikia',
	'ext.wikia.adEngine.lookup.prebid.adapters.veles',
	'wikia.window'
], function(aol, appnexus, index, wikia, veles, win) {
	'use strict';

	var adapters = [
			appnexus,
			index,
			aol
		],
		customAdapters = [
			wikia,
			veles
		];

	function getAdapters() {
		return adapters;
	}

	function push(adapter) {
		adapters.push(adapter);
	}

	function setupCustomAdapters() {
		customAdapters.forEach(function (adapter) {
			if (adapter && adapter.isEnabled()) {
				push(adapter);
				win.pbjs.que.push(function () {
					win.pbjs.registerBidAdapter(adapter.create, adapter.getName());
				});
			}
		});
	}

	return {
		getAdapters: getAdapters,
		push: push,
		setupCustomAdapters: setupCustomAdapters
	};
});
