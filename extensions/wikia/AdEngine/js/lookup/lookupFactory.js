/*global define*/
define('ext.wikia.adEngine.lookup.lookupFactory', [
	'ext.wikia.adEngine.adTracker',
	'wikia.log'
], function (adTracker, log) {
	'use strict';

	function create(module) {
		var called = false,
			response = false,
			timing;

		function trackState(trackEnd) {
			log(['trackState', response], 'debug', module.logGroup);
			var eventName,
				data = {};

			if (response) {
				eventName = 'lookupSuccess';
				data = module.getPrices();
			} else {
				eventName = 'lookupError';
			}

			if (trackEnd) {
				eventName = 'lookupEnd';
			}

			log(['trackState', 'Prices', module.name, module.getPrices()], 'info', module.logGroup);
			adTracker.track(eventName + '/' + module.name, data || '(unknown)', 0);
		}

		function onResponse() {
			log('onResponse', 'debug', module.logGroup);
			timing.measureDiff({}, 'end').track();
			response = true;

			module.calculatePrices();
			trackState(true);
		}

		function call(skin) {
			log('call', 'debug', module.logGroup);

			if (typeof module.shouldCall === 'function' && !module.shouldCall()) {
				log(['call', 'Should not be called', module.name], 'debug', module.logGroup);
				return;
			}

			timing = adTracker.measureTime(module.name, {}, 'start');
			timing.track();

			module.call(skin, onResponse);
			called = true;
		}

		function wasCalled() {
			log(['wasCalled', called], 'debug', module.logGroup);
			return called;
		}

		function getSlotParams(slotName) {
			log(['getSlotParams', slotName, response], 'debug', module.logGroup);
			if (response) {
				return module.getSlotParams(slotName);
			}

			log(['getSlotParams - no price since ad has been already displayed', slotName], 'debug', module.logGroup);
			return {};
		}

		return {
			call: call,
			getSlotParams: getSlotParams,
			trackState: trackState,
			wasCalled: wasCalled
		};
	}

	return {
		create: create
	};
});
