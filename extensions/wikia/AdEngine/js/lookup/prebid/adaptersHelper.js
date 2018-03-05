/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adaptersHelper', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
], function (adContext, adLogicZoneParams) {
	'use strict';

	function getAdContext() {
		return adContext.getContext();
	}

	function getTargeting(slotName, skin) {
		var provider = skin === 'oasis' ? 'gpt' : 'mobile',
			s1 = getAdContext().targeting.wikiIsTop1000 ? adLogicZoneParams.getName() : 'not a top1k wiki';

		return {
			pos: [slotName],
			src: [provider],
			s0: [adLogicZoneParams.getSite()],
			s1: [s1],
			s2: [adLogicZoneParams.getPageType()],
			lang: [adLogicZoneParams.getLanguage()]
		};
	}

	return {
		getTargeting: getTargeting
	};
});
