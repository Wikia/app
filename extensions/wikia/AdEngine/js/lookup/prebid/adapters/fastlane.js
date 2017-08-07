/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.fastlane', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, slotsContext, adLogicZoneParams, geo, instantGlobals, log) {
	'use strict';

	var bidderName = 'fastlane',
		aliases = {
			'rubicon': [bidderName]
		},
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.fastlane',
		rubiconAccountId = 7450,
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [[728, 90], [970, 250]],
					targeting: {loc: 'top'},
					siteId: 41686,
					zoneId: 175094
				},
				TOP_RIGHT_BOXAD: {
					sizes: [[300, 250], [300, 600], [300, 1050]],
					targeting: {loc: 'top'},
					siteId: 41686,
					zoneId: 175094
				},
				LEFT_SKYSCRAPER_2: {
					sizes: [[120, 600], [160, 600], [300, 250], [300, 600], [300, 1050]],
					targeting: {loc: 'middle'},
					siteId: 41686,
					zoneId: 194452
				},
				LEFT_SKYSCRAPER_3: {
					sizes: [[120, 600], [160, 600], [300, 250], [300, 600]],
					targeting: {loc: 'footer'},
					siteId: 41686,
					zoneId: 194452
				},
				INCONTENT_BOXAD_1: {
					sizes: [[120, 600], [160, 600], [300, 250], [300, 600]],
					targeting: {loc: 'hivi'},
					siteId: 83830,
					zoneId: 395614
				},
				BOTTOM_LEADERBOARD: {
					sizes: [[728, 90], [970, 250]],
					targeting: {loc: 'footer'},
					siteId: 41686,
					zoneId: 194452
				},
				PREFOOTER_LEFT_BOXAD: {
					sizes: [[300, 250], [336, 280]],
					targeting: {loc: 'footer'},
					siteId: 41686,
					zoneId: 194452
				},
				PREFOOTER_MIDDLE_BOXAD: {
					sizes: [[300, 250]],
					targeting: {loc: 'footer'},
					siteId: 41686,
					zoneId: 194452
				},
				PREFOOTER_RIGHT_BOXAD: {
					sizes: [[300, 250]],
					targeting: {loc: 'footer'},
					siteId: 41686,
					zoneId: 194452
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [[300, 50], [300, 250], [320, 50], [320, 480]],
					siteId: 23565,
					zoneId: 87671
				},
				MOBILE_PREFOOTER: {
					sizes: [[300, 50], [300, 250], [320, 50]],
					siteId: 23565,
					zoneId: 87671
				},
				MOBILE_TOP_LEADERBOARD: {
					sizes: [[300, 50], [320, 50], [320, 480]],
					siteId: 23565,
					zoneId: 87671
				}
			}
		};

	function getContextTargeting() {
		return adContext.getContext().targeting;
	}

	function getTargeting(slotName, skin, passback) {
		var provider = skin === 'oasis' ? 'gpt' : 'mobile',
			s1 = getContextTargeting().wikiIsTop1000 ? adLogicZoneParams.getName() : 'not a top1k wiki';

		return {
			pos: slotName,
			src: provider,
			s0: adLogicZoneParams.getSite(),
			s1: s1,
			s2: adLogicZoneParams.getPageType(),
			lang: adLogicZoneParams.getLanguage(),
			passback: passback
		};
	}

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverRubiconFastlanePrebidCountries);
	}

	function prepareAdUnit(slotName, config, skin) {
		var position = slotName.indexOf('TOP') !== -1 ? 'atf' : 'btf',
			targeting = Object.assign({}, config.targeting, getTargeting(slotName, skin, 'fastlane')),
			adUnit = {
				code: slotName,
				sizes: config.sizes,
				bids: [
					{
						bidder: bidderName,
						params: {
							accountId: rubiconAccountId,
							siteId: config.siteId,
							zoneId: config.zoneId,
							name: slotName,
							position: position,
							keywords: ['rp.fastlane'],
							inventory: targeting
						}
					}
				]
			};

		log(['prepareAdUnit', adUnit], log.levels.debug, logGroup);
		return adUnit;
	}

	function getSlots(skin) {
		return slotsContext.filterSlotMap(slots[skin]);
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
