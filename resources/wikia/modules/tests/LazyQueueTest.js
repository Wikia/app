/**
 * @test-framework QUnit
 * @test-require-asset resources/wikia/modules/lazyqueue.js
 */

module('LazyQueue');

test('Queue callback is called for every item in array', function() {
	var queue = ['item0', 'item1', 'item2']
		, callback
		, callbackCalledTimes = 0
		, callbackCalledWithArgument = [];

	callback = function(arg) {
		callbackCalledTimes += 1;
		callbackCalledWithArgument.push(arg);
	};

	Wikia.LazyQueue().makeQueue(queue, callback);
	queue.start();

	equal(callbackCalledTimes, 3);
	equal(callbackCalledWithArgument[0], 'item0');
	equal(callbackCalledWithArgument[1], 'item1');
	equal(callbackCalledWithArgument[2], 'item2');
});

test('Queue callback is not called when queue is empty', function() {
	var queue = []
		, callbackCalled = false;

	callback = function() {
		callbackCalled = true;
	};
	Wikia.LazyQueue().makeQueue(queue, callback);
	queue.start();
	equal(callbackCalled, false);
});

test('Queue callback is called for each element pushed after start()', function() {
	var queue = []
		, callbackCalledTimes = 0
		, callbackCalledWithArguments = []
		, callback;

	callback = function(arg) {
		callbackCalledTimes += 1;
		callbackCalledWithArguments.push(arg);
	};

	Wikia.LazyQueue().makeQueue(queue, callback);
	queue.start();
	equal(callbackCalledTimes, 0, 'Callback not called after start');

	queue.push('item0');
	queue.push('item1');
	equal(callbackCalledTimes, 2, 'Callback called two times');
	equal(callbackCalledWithArguments[0], 'item0');
	equal(callbackCalledWithArguments[1], 'item1');
});

test('LazyQueue() throws if queue is not array', function() {
	var thrown = false
		, nullQueue = null
		, undefinedQueue
		, stringQueue = 'some string'
		, intQueue = 7
		, callback = function() {};

	try {
		Wikia.LazyQueue().start(nullQueue);
	} catch (e1) {
		thrown = true;
	}
	equal(thrown, true, 'Throws on null');

	try {
		Wikia.LazyQueue().start(undefinedQueue);
	} catch (e2) {
		thrown = true;
	}
	equal(thrown, true, 'Throws on undefined');

	try {
		Wikia.LazyQueue().start(stringQueue);
	} catch (e3) {
		thrown = true;
	}
	equal(thrown, true, 'Throws on stringQueue');

	try {
		Wikia.LazyQueue().start(intQueue);
	} catch (e4) {
		thrown = true;
	}
	equal(thrown, true, 'Throws on intQueue');
});
