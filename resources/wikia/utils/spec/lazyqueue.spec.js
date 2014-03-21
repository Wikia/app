describe('LazyQueue', function(){

	it('Queue callback is called for every item in array', function() {
		var queue = ['item0', 'item1', 'item2'],
			c = {
				callback: function() {}
			};

		spyOn(c, 'callback').andCallThrough();

		modules['wikia.lazyqueue']().makeQueue(queue, c.callback);
		queue.start();

		expect(c.callback.calls.length).toEqual(3);
		expect(c.callback.calls[0].args[0]).toEqual('item0');
		expect(c.callback.calls[1].args[0]).toEqual('item1');
		expect(c.callback.calls[2].args[0]).toEqual('item2');
	});

	it('Queue callback is not called when queue is empty', function() {
		var queue = [],
			c = {
				callback: function() {}
			};

		spyOn(c, 'callback').andCallThrough();

		modules['wikia.lazyqueue']().makeQueue(queue, c.callback);
		queue.start();
		expect(c.callback).not.toHaveBeenCalled();
	});

	it('Queue callback is called for each element pushed after start()', function() {
		var queue = [],
			c = {
				callback: function() {}
			};

		spyOn(c, 'callback').andCallThrough();

		modules['wikia.lazyqueue']().makeQueue(queue, c.callback);
		queue.start();
		expect(c.callback).not.toHaveBeenCalled();

		queue.push('item0');
		queue.push('item1');

		expect(c.callback.calls.length).toEqual(2);
		expect(c.callback.calls[0].args[0]).toEqual('item0');
		expect(c.callback.calls[1].args[0]).toEqual('item1');
	});

	it('LazyQueue throws if queue is not array', function() {
		var nullQueue = null
			, undefinedQueue
			, stringQueue = 'some string'
			, intQueue = 7
			, callback = function() {}
			, lazyQueue = modules['wikia.lazyqueue']();

		expect(function(){
			lazyQueue.makeQueue(nullQueue, callback);
		}).toThrow();

		expect(function(){
			lazyQueue.makeQueue(undefinedQueue, callback);
		}).toThrow();

		expect(function(){
			lazyQueue.makeQueue(stringQueue, callback);
		}).toThrow();

		expect(function(){
			lazyQueue.makeQueue(intQueue, callback);
		}).toThrow();
	});
});
