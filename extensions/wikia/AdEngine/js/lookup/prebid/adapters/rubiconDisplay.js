/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.rubiconDisplay', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.log'
], function (adContext, slotsContext, adLogicZoneParams, instartLogic, log) {
	'use strict';

	var bidderName = 'rubicon_display',
		aliases = {
			'rubicon': [bidderName]
		},
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.rubiconDisplay',
		rubiconAccountId = 7450,
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [[728, 90], [970, 250]],
					targeting: {loc: 'top'},
					position: 'atf',
					siteId: 148804,
					zoneId: 704672
				},
				TOP_RIGHT_BOXAD: {
					sizes: [[300, 250], [300, 600]],
					targeting: {loc: 'top'},
					position: 'atf',
					siteId: 148804,
					zoneId: 704672
				},
				INCONTENT_BOXAD_1: {
					sizes: [[160, 600], [300, 600], [300, 250]],
					targeting: {loc: 'hivi'},
					position: 'btf',
					siteId: 148804,
					zoneId: 704676
				},
				BOTTOM_LEADERBOARD: {
					sizes: [[728, 90], [970, 250]],
					targeting: {loc: 'footer'},
					position: 'btf',
					siteId: 148804,
					zoneId: 704674
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [[320, 50]],
					position: 'atf',
					siteId: 23565,
					zoneId: 87671
				},
				MOBILE_IN_CONTENT: {
					sizes: [[300, 250]],
					position: 'btf',
					siteId: 23565,
					zoneId: 87671
				},
				MOBILE_PREFOOTER: {
					sizes: [[300, 250], [320, 50]],
					position: 'btf',
					siteId: 23565,
					zoneId: 87671
				}
			}
		};

	function getAdContext() {
		return adContext.getContext();
	}

	function getTargeting(slotName, skin) {
		var provider = skin === 'oasis' ? 'gpt' : 'mobile',
			s1 = getAdContext().targeting.wikiIsTop1000 ? adLogicZoneParams.getName() : 'not a top1k wiki';

		return {
			pos: slotName,
			src: provider,
			s0: adLogicZoneParams.getSite(),
			s1: s1,
			s2: adLogicZoneParams.getPageType(),
			lang: adLogicZoneParams.getLanguage()
		};
	}

	function isEnabled() {
		return getAdContext().bidders.rubiconDisplay && !instartLogic.isBlocking();
	}

	function prepareAdUnit(slotName, config, skin) {
		var targeting = getTargeting(slotName, skin),
			adUnit,
			bidParams;

		Object.keys(config.targeting || {}).forEach(function (key) {
			targeting[key] = config.targeting[key];
		});

		bidParams = {
			accountId: rubiconAccountId,
			siteId: config.siteId,
			zoneId: config.zoneId,
			name: slotName,
			position: config.position,
			keywords: ['rp.fastlane'],
			inventory: targeting
		};

		adUnit = {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: bidParams
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
		getAliases: getAliases,
		getName: getName,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
