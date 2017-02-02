/*global define*/
define('ext.wikia.adEngine.mobile.mercuryListener', [
	'wikia.lazyqueue',
	'wikia.log'
], function (lazyQueue, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.mobile.mercuryListener',
		onLoadQueue = [],
		onPageChangeCallbacks = [],
		onEveryPageChangeCallbacks = [];

	function onLoad(callback) {
		onLoadQueue.push(callback);
	}

	function onPageChange(callback) {
		onPageChangeCallbacks.push(callback);
	}

	function onEveryPageChange(callback) {
		onEveryPageChangeCallbacks.push(callback);
	}

	function startOnLoadQueue() {
		log('startOnLoadQueue', 'info', logGroup);
		onLoadQueue.start();
	}

	function runOnPageChangeCallbacks() {
		var callback;
		log(['runOnPageChangeCallbacks', onPageChangeCallbacks.length], 'info', logGroup);

		while (onPageChangeCallbacks.length) {
			callback = onPageChangeCallbacks.shift();
			callback();
		}

		log(['runOnEveryPageChangeCallbacks', onEveryPageChangeCallbacks.length], 'info', logGroup);
		onEveryPageChangeCallbacks.forEach(function(callback) {
			callback();
		});
	}

	lazyQueue.makeQueue(onLoadQueue, function (callback) {
		callback();
	});

	return {
		onLoad: onLoad,
		onPageChange: onPageChange,
		onEveryPageChange: onEveryPageChange,
		startOnLoadQueue: startOnLoadQueue,
		runOnPageChangeCallbacks: runOnPageChangeCallbacks
	};
});
