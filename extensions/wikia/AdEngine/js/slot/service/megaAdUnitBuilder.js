/*global define*/
define('ext.wikia.adEngine.slot.service.megaAdUnitBuilder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.context.slotsContext',
	'ext.wikia.adEngine.utils.device'
], function (adContext, page, slotsContext, deviceDetect) {
	'use strict';

	var dfpId = '5441',
		megaSlots = [
			'INVISIBLE_SKIN',
			'BOTTOM_LEADERBOARD'
		],
		context;

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
			'MR': ['TOP_RIGHT_BOXAD'],
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

	function build(slotName, src, slotNameSuffix) {
		var adUnitElements,
			params = page.getPageLevelParams(),
			device = getDeviceSpecial(params),
			provider = src.indexOf('remnant') === -1 ? 'wka1a' : 'wka2a',
			wikiName = getContextTargeting().wikiIsTop1000 ? params.s1 : '_not_a_top1k_wiki',
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
		return adUnit.indexOf('wka1a.') !== -1 || adUnit.indexOf('wka2a.') !== -1;
	}

	function getShortSlotName(adUnit) {
		return adUnit.replace(/^.*\/(wka1a|wka2a)\.[\w]+\/([^\/]*)\/.*$/, function () {
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
