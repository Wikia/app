/*global define*/
define('ext.wikia.adEngine.tracking.moatYi', [
	'ext.wikia.adEngine',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.services',
	'ext.wikia.adEngine.tracking.pageInfoTracker'
], function (
	adEngine3,
	adContext,
	pageLevelParams,
	services,
	pageInfoTracker
) {
	'use strict';

	if (!services.moatYi) {
		return;
	}

	function call() {
		adEngine3.context.set('services.moatYi.enabled', adContext.get('opts.moatYi'));
		adEngine3.context.set('services.moatYi.partnerCode', 'wikiaprebidheader490634422386');

		adEngine3.events.on(adEngine3.events.MOAT_YI_READY, function (data) {
			pageInfoTracker.trackProp('moat_yi', data);
		});

		services.moatYi.call()
			.then(function () {
				pageLevelParams.add('tracking.m_data', adEngine3.context.get('targeting.m_data'));
			});
	}

	return {
		call: call
	};
});
