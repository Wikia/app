/*global define*/
define('ext.wikia.adEngine.slot.adUnitBuilder', [
	'ext.wikia.adEngine.adLogicPageParams',
	'wikia.browserDetect'
], function (page, browserDetect) {
	'use strict';

	var dfpId = '5441';

	function build(slotName, src) {
		var params = page.getPageLevelParams();

		if (slotName instanceof Array) {
			slotName = slotName[0];
		}

		return [
			'', dfpId, 'wka.' + params.s0, params.s1, '', params.s2, src, slotName
		].join('/');
	}

	function findSlotGroup(map, slotName) {
		var result = Object.keys(map).filter(function (name) {
			return map[name].indexOf(slotName) !== -1;
		});

		return result.length === 1 ? result[0] : null;
	}

	function getGroup(slotName) {
		var map = {
			'LB': ['TOP_LEADERBOARD'],
			'MR': ['TOP_RIGHT_BOXAD'],
			'SKY': ['LEFT_SKYSCRAPER_2', 'LEFT_SKYSCRAPER_3'],
			'PF': ['PREFOOTER_LEFT_BOXAD', 'PREFOOTER_MIDDLE_BOXAD', 'PREFOOTER_RIGHT_BOXAD', 'MOBILE_PREFOOTER'],
			'PX': ['INVISIBLE_SKIN', 'INVISIBLE_HIGH_IMPACT_2'],
			'HiVi': ['INCONTENT_BOXAD_1']
		}, result;

		result = findSlotGroup(map, slotName);
		// OTHER: 'BOTTOM_LEADERBOARD', 'INCONTENT_LEADERBOARD', 'EXIT_STITIAL_BOXAD_1'
		return result ? result : 'OTHER';
	}

	function getDevice(params) {
		var result = 'unknown';

		if (params.skin === 'oasis') {
			result = browserDetect.isMobile() ? 'tablet' : 'desktop';
		} else if (params.skin === 'mercury' || params.skin === 'mobile-wiki') {
			result = 'smartphone';
		}

		return result;
	}

	function buildNew(src, slotName, passback) {
		var adUnitElements,
			params = page.getPageLevelParams(),
			device = getDevice(params),
			skin = params.skin,
			pageType = params.s2,
			wikiName = params.s1,
			vertical = params.s0v;

		adUnitElements = ['', dfpId, src + '.' + getGroup(slotName), slotName, device, skin + '-' + pageType, wikiName + '-' + vertical];

		if (passback) {
			adUnitElements.push(passback);
		}

		return adUnitElements.join('/');
	}

	return {
		build: build,
		buildNew: buildNew
	};
});
