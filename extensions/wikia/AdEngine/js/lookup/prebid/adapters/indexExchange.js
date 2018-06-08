/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.indexExchange',[
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext'
], function (adContext, slotsContext) {
	'use strict';

	var bidderName = 'indexExchange',
		requestsBidderName = 'ix',
		aliases = {
			'ix': [bidderName]
		},
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					siteId: 183423
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					siteId: 183567
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					siteId: 185049
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					siteId: 209250
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					],
					siteId: 183568
				},
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250],
						[320, 480]
					],
					siteId: 185055
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[300, 250],
						[320, 50]
					],
					siteId: 185056
				}
			},
			recovery: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					siteId: 215807
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					],
					siteId: 215808
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[160, 600],
						[300, 600],
						[300, 250]
					],
					siteId: 215809
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					],
					siteId: 215810
				}
			}
		};

	function isEnabled() {
		return adContext.get('bidders.indexExchange');
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			mediaTypes: {
				banner: {
					sizes: config.sizes
				}
			},
			bids: config.sizes.map(function (size) {
				return {
					bidder: requestsBidderName,
					params: {
						siteId: String(config.siteId),
						size: size
					}
				};
			})
		};
	}

	function getName() {
		return bidderName;
	}

	function getAliases() {
		return aliases;
	}

	return {
		isEnabled: isEnabled,
		getName: getName,
		getAliases: getAliases,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
