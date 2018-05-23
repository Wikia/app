/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adaptersRegistry', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.prebid.adapters.aol',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexus',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexusAst',
	'ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds',
	'ext.wikia.adEngine.lookup.prebid.adapters.audienceNetwork',
	'ext.wikia.adEngine.lookup.prebid.adapters.beachfront',
	'ext.wikia.adEngine.lookup.prebid.adapters.indexExchange',
	'ext.wikia.adEngine.lookup.prebid.adapters.openx',
	'ext.wikia.adEngine.lookup.prebid.adapters.onemobile',
	'ext.wikia.adEngine.lookup.prebid.adapters.pubmatic',
	'ext.wikia.adEngine.lookup.prebid.adapters.rubicon',
	'ext.wikia.adEngine.lookup.prebid.adapters.rubiconDisplay',
	'ext.wikia.adEngine.lookup.prebid.adapters.wikia',
	'ext.wikia.adEngine.lookup.prebid.adapters.wikiaVideo',
	'ext.wikia.adEngine.lookup.prebid.versionCompatibility',
	'wikia.window'
], function(
	adContext,
	aol,
	appnexus,
	appnexusAst,
	appnexusWebAds,
	audienceNetwork,
	beachfront,
	indexExchange,
	onemobile,
	openx,
	pubmatic,
	rubicon,
	rubiconDisplay,
	wikia,
	wikiaVideo,
	prebidVersionCompatibility,
	win
) {
	'use strict';

	var adapters = [
			aol,
			appnexus,
			appnexusAst,
			appnexusWebAds,
			audienceNetwork,
			beachfront,
			indexExchange,
			onemobile,
			openx,
			pubmatic,
			rubicon,
			rubiconDisplay
		],
		customAdapters = [
			wikia,
			wikiaVideo
		];

	function getAdapters() {
		return adapters;
	}

	function push(adapter) {
		adapters.push(adapter);
	}

	function registerAliases() {
		var isNewPrebidEnabled = adContext.get('opts.isNewPrebidEnabled');

		adapters.forEach(function (adapter) {
			var aliasMap = {};

			if (typeof adapter.getAliases === 'function') {
				win.pbjs.que.push(function () {
					aliasMap = isNewPrebidEnabled ?
						adapter.getAliases() :
						prebidVersionCompatibility.toVersion0.decorateGetAliases(adapter.getAliases)();

					Object.keys(aliasMap).forEach(function (bidderName) {
						aliasMap[bidderName].forEach(function (alias) {
							win.pbjs.aliasBidder(bidderName, alias);
						});
					});
				});
			}
		});
	}

	function setupCustomAdapters() {
		customAdapters.forEach(function (adapter) {
			push(adapter);
			win.pbjs.que.push(function () {
				win.pbjs.registerBidAdapter(adapter.create, adapter.getName());
			});
		});
	}

	function getPriorities() {
		var priority = {};

		adapters.forEach(function (adapter) {
			priority[adapter.getName()] = typeof adapter.getPriority === 'function' ? adapter.getPriority() : 1;
		});

		return priority;
	}

	return {
		getAdapters: getAdapters,
		getPriorities: getPriorities,
		push: push,
		registerAliases: registerAliases,
		setupCustomAdapters: setupCustomAdapters
	};
});
