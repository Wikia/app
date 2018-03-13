/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds',[
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (slotsContext, geo, instantGlobals, log) {
	'use strict';

	var bidderName = 'appnexusWebAds',
		aliases = {
			'appnexusAst': [bidderName]
		},
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds',
		priorityLevel = 0,
		slots = {
			oasis: {
				INCONTENT_BOXAD_1: {
					placementId: '11283988',
					sizes: [
						[300, 600],
						[300, 250],
						[120, 600],
						[160, 600]
					]
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAppNexusWebAdsBidderCountries);
	}

	function prepareAdUnit(slotName, config) {
		var placementId = config.placementId;

		log(['Requesting appnexusWebAds ad', slotName, placementId], log.levels.debug, logGroup);

		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: placementId
					}
				}
			]
		};
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function getName() {
		return bidderName;
	}

	function getPriority() {
		return priorityLevel;
	}

	function getAliases() {
		return aliases;
	}

	return {
		isEnabled: isEnabled,
		getName: getName,
		getPriority: getPriority,
		getAliases: getAliases,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
