/*global define*/
define('ext.wikia.adEngine.mobile.mercuryListener', [
	'wikia.lazyqueue',
	'wikia.log'
], function (lazyQueue, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.mobile.mercuryListener',
		onLoadQueue = [];

	function onLoad(callback) {
		onLoadQueue.push(callback);
	}

	function startOnLoadQueue() {
		log('startOnLoadQueue', 'info', logGroup);
		onLoadQueue.start();
	}

	lazyQueue.makeQueue(onLoadQueue, function (callback) {
		callback();
	});

	return {
		onLoad: onLoad,
		startOnLoadQueue: startOnLoadQueue
	};
});
