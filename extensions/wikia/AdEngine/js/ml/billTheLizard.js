/*global define*/
define('ext.wikia.adEngine.ml.billTheLizard', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.geo',
	'ext.wikia.adEngine.utils.device',
	'wikia.instantGlobals',
	'wikia.log'
], function (adContext, pageLevelParams, bridge, geo, deviceDetect, instantGlobals, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.billTheLizard';

	if (!bridge.billTheLizard) {
		return;
	}

	function isApplicable(name) {
		if (name.indexOf('ctp_desktop') === 0) {
			return adContext.get('targeting.hasFeaturedVideo');
		}

		return true;
	}

	function call() {
		var config = instantGlobals.wgAdDriverBillTheLizardConfig || {},
			featuredVideoData = adContext.get('targeting.featuredVideo') || {},
			pageParams = pageLevelParams.getPageLevelParams();

		bridge.context.set('services.billTheLizard.models', []);
		bridge.context.set('services.billTheLizard.parameters', {
			device: deviceDetect.getDevice(pageParams),
			esrb: pageParams.esrb || null,
			geo: geo.getCountryCode() || null,
			ref: pageParams.ref || null,
			s0v: pageParams.s0v || null,
			s2: pageParams.s2 || null,
			top_1k: adContext.get('targeting.wikiIsTop1000') ? 1 : 0,
			wiki_id: adContext.get('targeting.wikiId') || null,
			video_id: featuredVideoData.mediaId || null,
			video_tags: featuredVideoData.videoTags || null
		});
		bridge.context.set('services.billTheLizard.timeout', config.timeout || 0);

		Object.keys(config.models || {}).forEach(function (name) {
			var countriesList = config.models[name];

			if (isApplicable(name) && geo.isProperGeo(countriesList, name)) {
				bridge.context.push('services.billTheLizard.models', name);
			}
		});

		bridge.billTheLizard.call()
			.then(() => {
				log(['respond'], log.levels.debug, logGroup);
			}, () => {
				log(['reject'], log.levels.debug, logGroup);
			});
	}

	return {
		call: call,
		serialize: function () {
			return bridge.billTheLizard.serialize();
		}
	};
});
