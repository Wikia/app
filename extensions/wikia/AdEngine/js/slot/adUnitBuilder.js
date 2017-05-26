/*global define*/
define('ext.wikia.adEngine.slot.adUnitBuilder', [
	'ext.wikia.adEngine.adLogicPageParams'
], function (page) {
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

	function getShortSlotName(adUnit) {
		return adUnit.replace(/^.*\/([^\/]*)$/, '$1');
	}

	return {
		build: build,
		getShortSlotName: getShortSlotName
	};
});
