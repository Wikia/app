/*global define*/
define('ext.wikia.adEngine.provider.directGptMaps', [
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.wikiaGptHelper'
], function (log, document, wikiaGpt) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.directGptMobile';

	function fillInSlot(slotname, success, hop) {
		log(['fillInSlot', slotname], 'debug', logGroup);

		function showAdAndCallSuccess() {
			document.getElementById(slotname).className += ' show';
			success();
		}

		wikiaGpt.pushAd(slotname, showAdAndCallSuccess, hop, 'maps');
		wikiaGpt.flushAds();
	}

	return {
		name: 'DirectGptMaps',
		fillInSlot: fillInSlot
	};
});
