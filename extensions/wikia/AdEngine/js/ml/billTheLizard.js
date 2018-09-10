/*global define*/
define('ext.wikia.adEngine.ml.billTheLizard', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.geo',
	'ext.wikia.adEngine.ml.billTheLizardExecutor',
	'ext.wikia.adEngine.utils.device',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.trackingOptIn'
], function (adContext, pageLevelParams, bridge, geo, executor, deviceDetect, instantGlobals, log, trackingOptIn) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.billTheLizard',
		ready = false;

	if (!bridge.billTheLizard) {
		return;
	}

	function setupProjects() {
		if (adContext.get('targeting.hasFeaturedVideo')) {
			bridge.billTheLizard.projectsHandler.enable('queen_of_hearts');
		}
	}

	function setupExecutor() {
		executor.methods.forEach(function (methodName) {
			bridge.billTheLizard.executor.register(methodName, executor[methodName]);
		});
	}

	function call() {
		var config = instantGlobals.wgAdDriverBillTheLizardConfig || {},
			featuredVideoData = adContext.get('targeting.featuredVideo') || {},
			pageParams = pageLevelParams.getPageLevelParams();

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
		bridge.context.set('services.billTheLizard.projects', config.projects);
		bridge.context.set('services.billTheLizard.timeout', config.timeout || 0);

		setupProjects();
		setupExecutor();

		trackingOptIn.pushToUserConsentQueue(function () {
			return bridge.billTheLizard.call()
				.then(function () {
					ready = true;
					log(['respond'], log.levels.debug, logGroup);
				}, function () {
					ready = true;
					log(['reject'], log.levels.debug, logGroup);
				});
		});
	}

	function hasResponse() {
		return ready;
	}

	return {
		call: call,
		hasResponse: hasResponse,
		serialize: function () {
			return bridge.billTheLizard.serialize();
		}
	};
});
