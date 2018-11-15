/*global define*/
define('ext.wikia.adEngine.ml.billTheLizard', [
	'ext.wikia.adEngine',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.bridge',
	'ext.wikia.adEngine.ml.billTheLizardExecutor',
	'ext.wikia.adEngine.ml.bucketizers',
	'ext.wikia.adEngine.services',
	'ext.wikia.adEngine.tracking.pageInfoTracker',
	'ext.wikia.adEngine.utils.device',
	'wikia.browserDetect',
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
	bucketizers,
	services,
	pageInfoTracker,
	deviceDetect,
	browserDetect,
	doc,
	instantGlobals,
	log,
	trackingOptIn,
	win
) {
	'use strict';

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
					browser: browserDetect.getBrowser().split(' ')[0],
					device: deviceDetect.getDevice(pageParams),
					esrb: pageParams.esrb || null,
					geo: adEngineBridge.geo.getCountryCode() || null,
					lang: pageParams.lang,
					npa: pageParams.npa,
					os: browserDetect.getOS(),
					pv: Math.min(30, pageParams.pv || 1),
					pv_global: Math.min(40, win.pvNumberGlobal || 1),
					ref: pageParams.ref || null,
					s0v: pageParams.s0v || null,
					s2: pageParams.s2 || null,
					top_1k: adContext.get('targeting.wikiIsTop1000') ? 1 : 0,
					video_id: featuredVideoData.mediaId || null,
					video_tags: featuredVideoData.videoTags || null,
					viewport_height: bucketizers.bucketizeViewportHeight(Math.max(
						doc.documentElement.clientHeight, win.innerHeight || 0
					)),
					wiki_id: adContext.get('targeting.wikiId') || null
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
					var values = serialize();

					if (values) {
						pageLevelParams.add('btl', adEngine3.context.get('targeting.btl'));
						pageInfoTracker.trackProp('btl', values);
					}
				});
		});
	}

	function getResponseStatus() {
		return services.billTheLizard.getResponseStatus();
	}

	function serialize() {
		return services.billTheLizard.serialize();
	}

	return {
		call: call,
		getResponseStatus: getResponseStatus,
		serialize: serialize
	};
});
