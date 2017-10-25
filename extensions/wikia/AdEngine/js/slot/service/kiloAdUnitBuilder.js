/*global define*/
define('ext.wikia.adEngine.slot.service.kiloAdUnitBuilder', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams'
], function (adContext, page) {
	'use strict';

	var dfpId = '5441',
		context;

	function getContextTargeting() {
		if (!context) {
			context = adContext.getContext();
		}

		return context.targeting;
	}

	function build(slotName, src) {
		var params = page.getPageLevelParams();

		if (slotName instanceof Array) {
			slotName = slotName[0];
		}

		var wikiName = getContextTargeting().wikiIsTop1000 ? params.s1 : '_not_a_top1k_wiki';
		return [
			'', dfpId, 'wka.' + params.s0, wikiName, '', params.s2, src, slotName
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
