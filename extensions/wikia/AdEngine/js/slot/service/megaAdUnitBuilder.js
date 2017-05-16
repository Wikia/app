/*global define*/
define('ext.wikia.adEngine.slot.service.megaAdUnitBuilder', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.browserDetect'
], function (page, browserDetect) {
	'use strict';

	var dfpId = '5441';

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
			'SKY': ['LEFT_SKYSCRAPER_2', 'LEFT_SKYSCRAPER_3'],
			'PF': ['PREFOOTER_LEFT_BOXAD', 'PREFOOTER_MIDDLE_BOXAD', 'PREFOOTER_RIGHT_BOXAD', 'MOBILE_PREFOOTER'],
			'PX': ['INVISIBLE_SKIN', 'INVISIBLE_HIGH_IMPACT_2'],
			'HiVi': ['INCONTENT_BOXAD_1', 'MOBILE_IN_CONTENT']
		};

		// OTHER: 'BOTTOM_LEADERBOARD', 'MOBILE_BOTTOM_LEADERBOARD', 'INCONTENT_LEADERBOARD'
		return findSlotGroup(map, slotName) || 'OTHER';
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

	function build(slotName, src, passback) {
		var adUnitElements,
			params = page.getPageLevelParams(),
			device = getDevice(params),
			skin = params.skin,
			pageType = params.s2,
			provider = src.indexOf('remnant') === -1 ? 'wka1' : 'wka2',
			wikiName = params.s1,
			vertical = params.s0;

		adUnitElements = [
			'',
			dfpId,
			provider + '.' + getGroup(slotName),
			slotName.toLowerCase(),
			device,
			skin + '-' + pageType,
			wikiName + '-' + vertical
		];

		if (passback) {
			adUnitElements.push(passback);
		}

		return adUnitElements.join('/');
	}

	function isValid(adUnit) {
		return adUnit.indexOf('wka1.') !== -1 || adUnit.indexOf('wka2.') !== -1;
	}

	function getShortSlotName(adUnit) {
		return adUnit.replace(/^.*\/(wka1|wka2)\.[\w]+\/([^\/]*)\/.*$/, function () {
			if (arguments[2]) {
				return arguments[2].toUpperCase();
			}
		});
	}

	return {
		build: build,
		getShortSlotName: getShortSlotName,
		isValid: isValid
	};
});
