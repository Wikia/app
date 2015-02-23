/*global define*/
define('ext.wikia.adEngine.provider.directGptMaps', [
	'wikia.log',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.wikiaGptHelper'
], function (log, adLogicPageParams, wikiaGpt) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.directGptMobile';

	function fillInSlot(slotName, success, hop) {
		log(['fillInSlot', slotName], 'debug', logGroup);

		var pageParams = adLogicPageParams.getPageLevelParams(),
			slotPath = '/5441/wka.' + pageParams.s0 + '/' + pageParams.s1 + '//' + pageParams.s2 + '/maps/' + slotName,
			slotTargeting = { size: '320x50,1x1', pos: slotName, src: 'maps' };

		wikiaGpt.pushAd(slotName, slotPath, slotTargeting, success, hop);
		wikiaGpt.flushAds();
	}

	return {
		name: 'DirectGptMaps',
		fillInSlot: fillInSlot
	};
});
