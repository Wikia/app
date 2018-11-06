/*global define*/
define('ext.wikia.adEngine.ml.billTheLizard', [
	'ext.wikia.adEngine',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.ml.billTheLizardExecutor',
	'ext.wikia.adEngine.services',
	'ext.wikia.adEngine.tracking.pageInfoTracker',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'ext.wikia.adEngine.utils.device',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.trackingOptIn',
	'wikia.window'
], function (
	adEngine3,
	adContext,
	pageLevelParams,
	adEngineBridge,
	executor,
	services,
	pageInfoTracker,
	zoneParams,
	deviceDetect,
	doc,
	instantGlobals,
	log,
	trackingOptIn,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.billTheLizard',
		ready = false;

	if (!services.billTheLizard) {
		return;
	}

	function setupProjects() {
		if (adContext.get('targeting.hasFeaturedVideo')) {
			services.billTheLizard.projectsHandler.enable('queen_of_hearts');
		}
	}

	function setupExecutor() {
		executor.methods.forEach(function (methodName) {
			services.billTheLizard.executor.register(methodName, executor[methodName]);
		});
	}

	/**
	 * <400 as 400, 400-499 as 500, 500-599 as 600, 600-699 as 700,
	 * 700-799 as 800, 800-900 as 899, 900-999 as 1000
	 * and all from 1000 as 1100
	 *
	 * @param {Number} height
	 * @returns {Number}
	 */
	function bucketizeViewportHeight(height) {
		var buckets = [
			0, 400, 500, 600, 700, 800, 900, 1000
		];
		var bucket = 1100;
		for (var i = 1; i < buckets.length; i++) {
			if (height >= buckets[i-1] && height < buckets[i]) {
				bucket = buckets[i];
			}
		}
		return bucket.toString();
	}

	function call() {
		var config = instantGlobals.wgAdDriverBillTheLizardConfig || {},
			featuredVideoData = adContext.get('targeting.featuredVideo') || {},
			pageParams = pageLevelParams.getPageLevelParams();

		adEngine3.context.set('services.billTheLizard', {
			enabled: true,
			host: 'https://services.wikia.com',
			endpoint: 'bill-the-lizard/predict',
			parameters: {
				queen_of_hearts: {
					device: deviceDetect.getDevice(pageParams),
					esrb: pageParams.esrb || null,
					geo: adEngineBridge.geo.getCountryCode() || null,
					ref: pageParams.ref || null,
					s0v: pageParams.s0v || null,
					s2: pageParams.s2 || null,
					top_1k: adContext.get('targeting.wikiIsTop1000') ? 1 : 0,
					wiki_id: adContext.get('targeting.wikiId') || null,
					video_id: featuredVideoData.mediaId || null,
					video_tags: featuredVideoData.videoTags || null,
					viewport_height: bucketizeViewportHeight(Math.max(
						doc.documentElement.clientHeight, win.innerHeight || 0
					)),
					lang: zoneParams.getLanguage(),
				}
			},
			projects: config.projects,
			timeout: config.timeout || 0
		});

		if (window.wgServicesExternalDomain) {
			adEngine3.context.set('services.billTheLizard.host',
				window.wgServicesExternalDomain.replace(/\/$/, ''));
		}

		setupProjects();
		setupExecutor();

		trackingOptIn.pushToUserConsentQueue(function () {
			adEngine3.events.on(adEngine3.events.BILL_THE_LIZARD_REQUEST, function (query) {
				pageInfoTracker.trackProp('btl_request', query);
			});

			return services.billTheLizard.call(['queen_of_hearts'])
				.then(function () {
					ready = true;
					log(['respond'], log.levels.debug, logGroup);

					var values = serialize();

					if (values) {
						pageLevelParams.add('btl', adEngine3.context.get('targeting.btl'));
						pageInfoTracker.trackProp('btl', values);
					}
				}, function () {
					ready = true;
					log(['reject'], log.levels.debug, logGroup);
				});
		});
	}

	function hasResponse() {
		return ready;
	}

	function serialize() {
		return services.billTheLizard.serialize();
	}

	return {
		call: call,
		hasResponse: hasResponse,
		serialize: serialize,
		// export for testing purpose
		bucketizeViewportHeight: bucketizeViewportHeight
	};
});
