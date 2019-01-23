/*global define*/
define('ext.wikia.adEngine.slot.service.megaAdUnitBuilder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.utils.device',
	'ext.wikia.adEngine.bridge'
], function (adContext, page, slotsContext, deviceDetect, adEngineBridge) {
	'use strict';

	var dfpId = '5441',
		megaSlots = [
			'TOP_LEADERBOARD',
			'TOP_BOXAD',
			'INVISIBLE_SKIN',
			'BOTTOM_LEADERBOARD',
			'INCONTENT_PLAYER'
		],
		context,
		serverPrefix = adEngineBridge.geo.isProperCountry(['AU', 'NZ']) ? 'vm' : 'wka',
		wka1 = serverPrefix + '1b',
		wka2 = serverPrefix + '2b',
		shortSlotNameRegexp = new RegExp('^.*\/(' + wka1 + '|' + wka2 + ').[\\w]+\/([^\/]*)\/.*$');

	if (adContext.get('opts.incontentPlayerRail.enabled')) {
		megaSlots.push('INCONTENT_PLAYER');
	}

	function getContextTargeting() {
		if (!context) {
			context = adContext.getContext();
		}

		return context.targeting;
	}

	function findSlotGroup(map, slotName) {
		var result = Object.keys(map).filter(function (name) {
			return map[name].indexOf(slotName) !== -1;
		});

		return result.length === 1 ? result[0] : null;
	}

	function getGroup(slotName) {
		var map = {
			'LB': ['TOP_LEADERBOARD', 'MOBILE_TOP_LEADERBOARD'],
			'MR': ['TOP_BOXAD'],
			'PF': ['MOBILE_PREFOOTER', 'BOTTOM_LEADERBOARD'],
			'PX': ['INVISIBLE_SKIN', 'INVISIBLE_HIGH_IMPACT', 'INVISIBLE_HIGH_IMPACT_2'],
			'HiVi': ['INCONTENT_BOXAD_1', 'INCONTENT_PLAYER', 'MOBILE_IN_CONTENT'],
			'VIDEO': ['FEATURED', 'OUTSTREAM', 'UAP_BFAA', 'UAP_BFAB', 'ABCD', 'VIDEO']
		};

		return findSlotGroup(map, slotName.toUpperCase()) || 'OTHER';
	}

	function getDeviceSpecial(params) {
		if (params.s2 === 'special') {
			return 'unknown-specialpage';
		}

		return deviceDetect.getDevice(params);
	}

	function getWikiName(slotName, s1) {
		slotName = slotName.toLowerCase();
		if (!getContextTargeting().wikiIsTop1000) {
			return '_not_a_top1k_wiki';
		} else if (slotName === 'outstream' || slotName === 'featured') {
			return s1;
		}
		return '_top1k_wiki';
	}

	function build(slotName, src, slotNameSuffix) {
		var adUnitElements,
			params = page.getPageLevelParams(),
			device = getDeviceSpecial(params),
			provider = src.indexOf('remnant') === -1 ? wka1 : wka2,
			wikiName = getWikiName(slotName, params.s1),
			vertical = params.s0;

		adUnitElements = [
			'',
			dfpId,
			provider + '.' + getGroup(slotName),
			slotName.toLowerCase() + (slotNameSuffix || ''),
			device,
			params.skin + '-' + getAdLayout(params),
			wikiName + '-' + vertical
		];

		return adUnitElements.join('/');
	}

	function getAdLayout(params) {
		var layout = params.s2,
			incontentSlotName = params.skin === 'oasis' ? 'INCONTENT_PLAYER' : 'MOBILE_IN_CONTENT';

		if (slotsContext.isApplicable(incontentSlotName)) {
			layout = layout + '-ic';
		}

		return layout;
	}

	function isValid(adUnit) {
		return adUnit.indexOf(wka1 + '.') !== -1 || adUnit.indexOf(wka2 + '.') !== -1;
	}

	function getShortSlotName(adUnit) {
		return adUnit.replace(shortSlotNameRegexp, function () {
			if (arguments[2]) {
				return arguments[2].toUpperCase();
			}
		});
	}

	function isMegaSlot(slotName) {
		return megaSlots.indexOf(slotName) !== -1;
	}

	adContext.addCallback(function () {
		context = null;
	});

	return {
		build: build,
		getShortSlotName: getShortSlotName,
		isValid: isValid,
		isMegaSlot: isMegaSlot
	};
});
