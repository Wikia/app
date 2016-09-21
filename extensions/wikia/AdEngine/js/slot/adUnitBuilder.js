/*global define*/
define('ext.wikia.adEngine.slot.adUnitBuilder', [
	'ext.wikia.adEngine.adLogicPageParams',
], function (page) {
	'use strict';

	var dfpId = '5441';

	function build(slotName, src) {
		var pageLevelParams = page.getPageLevelParams();
		return '/' + dfpId + '/wka.' + pageLevelParams.s0 + '/' + pageLevelParams.s1 +
			'//' + pageLevelParams.s2 + '/' + src + '/' + slotName;
	}

	return {
		build: build
	};
});
