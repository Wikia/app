/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/lazyqueue.js
 */

/*global describe, it, runs, waitsFor, expect, require*/
describe("LazyQueue", function () {
	'use strict';

	var async = new AsyncSpec(this);

	async.it('Queue callback is called for every item in array', function(done) {
		require(['lazyqueue'], function(lazyqueue) {
			var queue = ['item0', 'item1', 'item2']
				, callback
				, callbackCalledTimes = 0
				, callbackCalledWithArgument = [];

			callback = function(arg) {
				callbackCalledTimes += 1;
				callbackCalledWithArgument.push(arg);
			};

			lazyqueue.makeQueue(queue, callback);
			queue.start();

			expect(callbackCalledTimes).toBe(3);
			expect(callbackCalledWithArgument[0]).toBe('item0');
			expect(callbackCalledWithArgument[1]).toBe('item1');
			expect(callbackCalledWithArgument[2]).toBe('item2');

			done();
		});
	});

	async.it('Queue callback is not called when queue is empty', function(done) {
		require(['lazyqueue'], function(lazyqueue) {
			var queue = []
				, callbackCalled = false;

			function callback() {
				callbackCalled = true;
			};
			lazyqueue.makeQueue(queue, callback);
			queue.start();
			expect(callbackCalled).toBe(false);

			done();
		});
	});

	async.it('Queue callback is called for each element pushed after start()', function(done) {
		require(['lazyqueue'], function(lazyqueue) {
			var queue = []
				, callbackCalledTimes = 0
				, callbackCalledWithArguments = []
				, callback;

			callback = function(arg) {
				callbackCalledTimes += 1;
				callbackCalledWithArguments.push(arg);
			};

			lazyqueue.makeQueue(queue, callback);
			queue.start();
			expect(callbackCalledTimes).toBe(0); // 'Callback not called after start'

			queue.push('item0');
			queue.push('item1');
			expect(callbackCalledTimes).toBe(2); // 'Callback called two times'
			expect(callbackCalledWithArguments[0]).toBe('item0');
			expect(callbackCalledWithArguments[1]).toBe('item1');

			done();
		});
	});

	async.it('LazyQueue throws if queue is not array', function(done) {
		require(['lazyqueue'], function(lazyqueue) {
			var thrown = false
				, nullQueue = null
				, undefinedQueue
				, stringQueue = 'some string'
				, intQueue = 7
				, callback = function() {};

			expect(function() {
				lazyqueue.makeQueue(nullQueue);
			}).toThrow(); // 'Throws on null'

			expect(function() {
				lazyqueue.makeQueue(undefinedQueue);
			}).toThrow(); // 'Throws on undefined'

			expect(function() {
				lazyqueue.makeQueue(stringQueue);
			}).toThrow(); // 'Throws on stringQueue');

			expect(function() {
				lazyqueue.makeQueue(intQueue);
			}).toThrow(); // 'Throws on intQueue');

			done();
		});
	});
});
