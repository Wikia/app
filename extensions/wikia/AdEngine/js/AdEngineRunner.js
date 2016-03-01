/*global define, require*/
define('ext.wikia.adEngine.adEngineRunner', [
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adTracker',
	'wikia.log',
	'wikia.window',
	require.optional('ext.wikia.adEngine.lookup.amazonMatch'),
	require.optional('ext.wikia.adEngine.lookup.rubiconFastlane')
], function (adEngine, adTracker, log, win, amazonMatch, rubiconFastlane) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adEngineRunner',
		supportedBidders = [amazonMatch, rubiconFastlane],
		timeout = 2000;

	/**
	 * Delay running AdEngine by bidder responses or by configured timeout
	 *
	 * @param {function} runAdEngine
	 */
	function delayRun(runAdEngine) {
		var enabledBidders = [],
			biddersQueue = [],
			startedByBidders = false;

		/**
		 * Mark bidder as responded and trigger run if all bidders already responded
		 *
		 * @param {string} name
		 */
		function markBidder(name) {
			log(name + ' responded', 'debug', logGroup);
			if (biddersQueue.indexOf(name) === -1) {
				biddersQueue.push(name);
			}
			if (biddersQueue.length === enabledBidders.length) {
				log('All bidders responded', 'info', logGroup);
				startedByBidders = true;
				runAdEngine();
			}
		}

		/**
		 * Add bidder listener to mark bidder on response
		 */
		function registerBidders() {
			log(['Register bidders', enabledBidders.length], 'debug', logGroup);
			enabledBidders.forEach(function (bidder) {
				var name = bidder.getName();
				bidder.addResponseListener(function () {
					markBidder(name);
				});
			});
		}

		supportedBidders.forEach(function (bidder) {
			if (bidder && bidder.wasCalled()) {
				enabledBidders.push(bidder);
			}
		});

		if (enabledBidders.length === 0) {
			log('All bidders are disabled', 'info', logGroup);
			runAdEngine();
		} else {
			registerBidders();
			win.setTimeout(function () {
				if (!startedByBidders) {
					log('Timeout exceeded', 'info', logGroup);
				}
				runAdEngine();
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
