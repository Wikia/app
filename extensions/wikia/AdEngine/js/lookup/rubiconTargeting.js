/*global define*/
define('ext.wikia.adEngine.lookup.rubiconTargeting', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.adLogicZoneParams'
], function (adContext, adLogicZoneParams) {
	'use strict';

	var context;

	function getContextTargeting() {
		if (!context) {
			context = adContext.getContext();
		}

		return context.targeting;
	}

	function getTargeting(slotName, skin, passback) {
		var provider = skin === 'oasis' ? 'gpt' : 'mobile',
			s1 = getContextTargeting().wikiIsTop1000 ? adLogicZoneParams.getName() : 'not a top1k wiki';

		return {
			pos: slotName,
			src: provider,
			s0: adLogicZoneParams.getSite(),
			s1: s1,
			s2: adLogicZoneParams.getPageType(),
			lang: adLogicZoneParams.getLanguage(),
			passback: passback
		};
	}

	return {
		getTargeting: getTargeting
	};
});
