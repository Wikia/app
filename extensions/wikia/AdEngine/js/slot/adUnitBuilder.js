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

	function getDevice(params) {
		var result = 'unknown';

		switch (params.skin) {
			case 'oasis':
				result = browserDetect.isMobile() ? 'tablet' : 'desktop';
			break;
			case 'mercury':
			case 'mobile-wiki':
				result = 'smartphone';
				break;
		}

		return result;
	}

	function buildNew(src, slotName, passback) {
		var params = page.getPageLevelParams(),
			device = getDevice(params),
			skin = params.skin,
			pageType = params.s2,
			wikiName = params.s1,
			vertical = params.s0v;

		return '/' + dfpId + '/' + src + '.' + slotName + '/' + device + '/' + skin + '-' + pageType + '/' + wikiName + '-' + vertical + '/' + passback;
	}

	return {
		build: build,
		buildNew: buildNew
	};
});
