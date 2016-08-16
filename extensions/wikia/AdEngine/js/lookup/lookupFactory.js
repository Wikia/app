/*global define*/
define('ext.wikia.adEngine.lookup.lookupFactory', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.log'
], function (adContext, adTracker, helper, doc, lazyQueue, log) {
	'use strict';

	function create(module) {
		var called = false,
			onResponseCallbacks = [],
			response = false,
			timing,
			context = adContext.getContext();

		function onResponse() {
			log('onResponse', 'debug', module.logGroup);

			timing.measureDiff({}, 'end').track();
			module.calculatePrices();
			response = true;
			onResponseCallbacks.start();

			adTracker.track(module.name + '/lookup_end', module.getPrices(), 0, 'nodata');
		}

		function addResponseListener(callback) {
			onResponseCallbacks.push(callback);
		}

		function call() {
			log('call', 'debug', module.logGroup);

			if (!Object.keys) {
				log(['call', 'Module is not supported in IE8', module.name], 'debug', module.logGroup);
				return;
			}

			timing = adTracker.measureTime(module.name, {}, 'start');
			timing.track();

			// in mercury ad context is being reloaded after XHR call that's why at this point we don't have skin
			module.call(context.targeting.skin || 'mercury', onResponse);
			called = true;

			helper.addResponseListener(onResponseCallbacks.start);
		}

		function wasCalled() {
			log(['wasCalled', called], 'debug', module.logGroup);
			return called;
		}

		function trackState(providerName, slotName, params) {
			log(['trackState', response, providerName, slotName], 'debug', module.logGroup);
			var category,
				encodedParams,
				eventName;

			if (!module.isSlotSupported(slotName)) {
				log(['trackState', 'Not supported slot', slotName], 'debug', module.logGroup);
				return;
			}

			encodedParams = module.encodeParamsForTracking(params);
			eventName = encodedParams ? 'lookup_success' : 'lookup_error';
			category = module.name + '/' + eventName + '/' + providerName;

			adTracker.track(category, slotName, 0, encodedParams || 'nodata');
		}

		function getSlotParams(slotName) {
			log(['getSlotParams', slotName, called, response], 'debug', module.logGroup);

			if (!called || !module.isSlotSupported(slotName)) {
				log(['getSlotParams', 'Not called or slot is not supported', slotName], 'debug', module.logGroup);
				return {};
			}

			return module.getSlotParams(slotName);
		}

		function getName() {
			return module.name;
		}

		// needed only for selenium tests
		function hasResponse() {
			log(['hasResponse', response], 'debug', module.logGroup);
			return response;
		}

		lazyQueue.makeQueue(onResponseCallbacks, function (callback) {
			callback();
		});

		return {
			addResponseListener: addResponseListener,
			call: call,
			getName: getName,
			getSlotParams: getSlotParams,
			hasResponse: hasResponse,
			trackState: trackState,
			wasCalled: wasCalled
		};
	}

	return {
		create: create
	};
});
