/*global define, require*/
define('ext.wikia.adEngine.adEngineRunner', [
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adTracker',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.amazonMatch'),
	require.optional('ext.wikia.adEngine.lookup.rubiconFastlane'),
	require.optional('ext.wikia.aRecoveryEngine.recovery.sourcePointRecovery')
], function (adEngine, adTracker, instantGlobals, log, win, amazonMatch, rubiconFastlane, spRecovery) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adEngineRunner',
		supportedModules = [amazonMatch, rubiconFastlane, spRecovery],
		timeout = instantGlobals.wgAdDriverDelayTimeout || 2000;

	/**
	 * Delay running AdEngine by module responses or by configured timeout
	 *
	 * @param {function} runAdEngine
	 */
	function delayRun(runAdEngine) {
		var modulesQueue = [],
			enabledModules = [],
			startedByModules = false;

		/**
		 * Mark module as responded and trigger run if all modules already responded
		 *
		 * @param {string} name
		 */
		function markModule(name) {
			log(name + ' responded', 'debug', logGroup);
			if (modulesQueue.indexOf(name) === -1) {
				modulesQueue.push(name);
			}
			if (modulesQueue.length === enabledModules.length) {
				log('All modules responded', 'info', logGroup);
				startedByModules = true;
				adTracker.measureTime('adengine_runner/modules_responded', modulesQueue.join(',')).track();
				runAdEngine();
			}
		}

		/**
		 * Add module listener to mark module on response
		 */
		function registerModules() {
			log(['Register modules', enabledModules.length], 'debug', logGroup);
			enabledModules.forEach(function (module) {
				var name = module.getName();
				module.addResponseListener(function () {
					markModule(name);
				});
			});
		}

		function getTimeoutModules () {
			var timeoutModules = [];

			enabledModules.forEach(function (enabledModule) {
				var enabledModuleName = enabledModule.getName();
				if (modulesQueue.indexOf(enabledModuleName) === -1) {
					timeoutModules.push(enabledModuleName);
				}
			});

			return timeoutModules.join(',');
		}

		supportedModules.forEach(function (module) {
			if (module && module.wasCalled()) {
				enabledModules.push(module);
			}
		});

		if (enabledModules.length === 0) {
			log('All modules are disabled', 'info', logGroup);
			runAdEngine();
		} else {
			registerModules();
			win.setTimeout(function () {
				if (!startedByModules) {
					log(['Timeout exceeded', timeout], 'info', logGroup);
					adTracker.measureTime('adengine_runner/modules_timeout', getTimeoutModules()).track();
					runAdEngine();
				}
			}, timeout);
		}
	}

	/**
	 * Decide whether AdEngine should be delayed and run slots queue
	 *
	 * @param {object} config - ext.wikia.adEngine.config.*
	 * @param {array} slots - slot names to fill in
	 * @param {string} queueName
	 * @param {boolean} delayEnabled
	 */
	function run(config, slots, queueName, delayEnabled) {
		var engineStarted = false;

		/**
		 * Run AdEngine once and track it
		 */
		function runAdEngine() {
			if (engineStarted) {
				return;
			}
			engineStarted = true;
			log('Running AdEngine', 'info', logGroup);
			adTracker.measureTime('adengine.init', queueName).track();
			adEngine.run(config, slots, queueName);
		}

		if (delayEnabled) {
			delayRun(runAdEngine);
		} else {
			log('Run AdEngine without delay', 'info', logGroup);
			runAdEngine();
		}
	}

	return {
		run: run
	};
});
