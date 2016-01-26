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

	function delayRun(runAdEngine) {
		var enabledBidders = [],
			biddersQueue = [];

		function markBidder(name) {
			log(name + ' responded', 'debug', logGroup);
			if (biddersQueue.indexOf(name) === -1) {
				biddersQueue.push(name);
			}
			if (biddersQueue.length === enabledBidders.length) {
				log('All bidders responded', 'info', logGroup);
				runAdEngine();
			}
		}

		function registerBidders() {
			log(['Register bidders', enabledBidders], 'debug', logGroup);
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
				log('Timeout exceeded', 'info', logGroup);
				runAdEngine();
			}, timeout);
		}
	}

	function run(config, slots, queueName, delayEnabled) {
		var engineStarted = false;

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
