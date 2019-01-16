/*global define*/
define('ext.wikia.adEngine.tracking.nielsen', [
	'ext.wikia.adEngine',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.services'
], function (
	adEngine3,
	adContext,
	pageLevelParams,
	services
) {
	'use strict';

	if (!services.nielsen) {
		return;
	}

	function call() {
		adEngine3.context.set('services.nielsen.enabled', adContext.get('opts.nielsen'));
		adEngine3.context.set('services.nielsen.appId', 'P26086A07-C7FB-4124-A679-8AC404198BA7');

		const pageParams = pageLevelParams.getPageLevelParams();

		services.nielsen.call({
			type: 'static',
			assetid: `fandom.com/${pageParams.s0v}/${pageParams.s1}/${pageParams.artid}`,
			section: `FANDOM ${pageParams.s0v.toUpperCase()} NETWORK`,
		});
	}

	return {
		call: call
	};
});
