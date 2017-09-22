/*global define*/
define('ext.wikia.adEngine.mobile.mercuryListener', [
	'wikia.lazyqueue',
	'wikia.log'
], function (lazyQueue, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.mobile.mercuryListener',
		onLoadQueue = [],
		onPageChangeCallbacks = [],
		onEveryPageChangeCallbacks = [],
		afterPageWithAdsRenderCallbacks = [];

	function onLoad(callback) {
		onLoadQueue.push(callback);
	}

	function onPageChange(callback) {
		onPageChangeCallbacks.push(callback);
	}

	function onEveryPageChange(callback) {
		onEveryPageChangeCallbacks.push(callback);
	}

	function afterPageWithAdsRender(callback) {
		afterPageWithAdsRenderCallbacks.push(callback);
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

	function runAfterPageWithAdsRenderCallbacks() {
		log(['runAfterPageWithAdsRenderCallbacks', afterPageWithAdsRenderCallbacks.length], 'info', logGroup);
		afterPageWithAdsRenderCallbacks.forEach(function(callback) {
			callback();
		});
	}

	lazyQueue.makeQueue(onLoadQueue, function (callback) {
		callback();
	});

	return {
		afterPageWithAdsRender: afterPageWithAdsRender,
		onEveryPageChange: onEveryPageChange,
		onLoad: onLoad,
		onPageChange: onPageChange,
		runAfterPageWithAdsRenderCallbacks: runAfterPageWithAdsRenderCallbacks,
		runOnPageChangeCallbacks: runOnPageChangeCallbacks,
		startOnLoadQueue: startOnLoadQueue
	};
});
