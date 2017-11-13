/*global define Promise*/
define('ext.wikia.adEngine.lookup.lookupFactory', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.promise',
	require.optional('ext.wikia.adEngine.mobile.mercuryListener')
], function (adContext, adTracker, adBlockDetection, lazyQueue, log, Promise, mercuryListener) {
	'use strict';

	function create(module) {
		var called,
			onResponseCallbacks,
			response,
			timing,
			context = adContext.getContext();

		function onResponse() {
			log('onResponse', 'debug', module.logGroup);
			timing.measureDiff({}, 'end').track();
			module.calculatePrices();
			response = true;
			onResponseCallbacks.start();

			if (module.name === 'prebid') {
				module.trackAdaptersOnLookupEnd();
			} else {
				adTracker.track(module.name + '/lookup_end', module.getPrices(), 0, 'nodata');
			}
		}

		function addResponseListener(callback) {
			onResponseCallbacks.push(callback);
		}

		function call() {
			log('call', 'debug', module.logGroup);
			response = false;

			if (!Object.keys) {
				log(['call', 'Module is not supported in IE8', module.name], 'debug', module.logGroup);
				return;
			}

			timing = adTracker.measureTime(module.name, {}, 'start');
			timing.track();

			// in mercury ad context is being reloaded after XHR call that's why at this point we don't have skin
			module.call(context.targeting.skin || 'mercury', onResponse);
			called = true;
			adBlockDetection.addOnBlockingCallback(onResponseCallbacks.start);
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

			if (module.name === 'prebid') {
				module.trackAdaptersSlotState(providerName, slotName, params);
			} else {
				encodedParams = module.encodeParamsForTracking(params, slotName);
				eventName = encodedParams ? 'lookup_success' : 'lookup_error';
				category = module.name + '/' + eventName + '/' + providerName;

				adTracker.track(category, slotName, 0, encodedParams || 'nodata');
			}
		}

		function getSlotParams(slotName, floorPrice) {
			log(['getSlotParams', slotName, called, response], 'debug', module.logGroup);

			if (!called || !module.isSlotSupported(slotName)) {
				log(['getSlotParams', 'Not called or slot is not supported', slotName], 'debug', module.logGroup);
				return {};
			}

			return module.getSlotParams(slotName, floorPrice);
		}

		function getBestSlotPrice(slotName) {
			if (module.getBestSlotPrice) {
				return module.getBestSlotPrice(slotName);
			}

			return {};
		}

		function getName() {
			return module.name;
		}

		// needed only for selenium tests
		function hasResponse() {
			log(['hasResponse', response], 'debug', module.logGroup);
			return response;
		}

		function isSlotSupported(slotName) {
			return module.isSlotSupported(slotName);
		}

		function resetState() {
			called = false;
			onResponseCallbacks = [];
			response = false;

			lazyQueue.makeQueue(onResponseCallbacks, function (callback) {
				callback();
			});
		}

		function waitForResponse(milisToTimeout) {
			return Promise.createWithTimeout(function (resolve) {
				if (hasResponse()) {
					resolve();
				} else {
					addResponseListener(resolve);
				}
			}, milisToTimeout);
		}

		resetState();

		if (mercuryListener) {
			mercuryListener.onEveryPageChange(resetState);
		}

		return {
			addResponseListener: addResponseListener,
			call: call,
			getBestSlotPrice: getBestSlotPrice,
			getName: getName,
			getSlotParams: getSlotParams,
			hasResponse: hasResponse,
			isSlotSupported: isSlotSupported,
			trackState: trackState,
			wasCalled: wasCalled,
			waitForResponse: waitForResponse
		};
	}

	return {
		create: create
	};
});
