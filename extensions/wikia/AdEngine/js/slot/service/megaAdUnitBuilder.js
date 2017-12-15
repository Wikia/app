/*global define*/
define('ext.wikia.adEngine.slot.service.megaAdUnitBuilder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.context.slotsContext',
	'wikia.browserDetect'
], function (adContext, page, slotsContext, browserDetect) {
	'use strict';

	var dfpId = '5441',
		context;

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
			'PF': [
				'MOBILE_PREFOOTER', 'BOTTOM_LEADERBOARD', 'MOBILE_BOTTOM_LEADERBOARD'
			],
			'PX': ['INVISIBLE_SKIN', 'INVISIBLE_HIGH_IMPACT', 'INVISIBLE_HIGH_IMPACT_2'],
			'HiVi': ['INCONTENT_BOXAD_1', 'MOBILE_IN_CONTENT'],
			'VIDEO': ['FEATURED', 'OUTSTREAM', 'UAP_BFAA', 'UAP_BFAB', 'ABCD', 'OOYALA', 'VIDEO']
		};

		// OTHER: 'INCONTENT_PLAYER'
		return findSlotGroup(map, slotName.toUpperCase()) || 'OTHER';
	}

	function getDevice(params) {
		var result = 'unknown';

		if (params.s2 === 'special') {
			return 'unknown-specialpage';
		}

		if (params.skin === 'oasis') {
			result = browserDetect.isMobile() ? 'tablet' : 'desktop';
		} else if (params.skin === 'mercury' || params.skin === 'mobile-wiki') {
			result = 'smartphone';
		}

		return result;
	}

	function build(slotName, src) {
		var adUnitElements,
			params = page.getPageLevelParams(),
			device = getDevice(params),
			provider = src.indexOf('remnant') === -1 ? 'wka1a' : 'wka2a',
			wikiName = getContextTargeting().wikiIsTop1000 ? params.s1 : '_not_a_top1k_wiki',
			vertical = params.s0;

		adUnitElements = [
			'',
			dfpId,
			provider + '.' + getGroup(slotName),
			slotName.toLowerCase(),
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

	adContext.addCallback(function () {
		context = null;
	});

	return {
		build: build,
		getShortSlotName: getShortSlotName,
		isValid: isValid
	};
});
