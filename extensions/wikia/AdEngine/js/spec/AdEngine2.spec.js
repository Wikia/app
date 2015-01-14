/*global describe,modules,it,expect,spyOn*/
/*jshint maxlen:200*/
/*jslint unparam:true*/

describe('AdEngine2', function () {
	'use strict';

	var eventDispatcher = { trigger: function () { return true; }},
		noop = function () { return; },
		slotTrackerMock = function () { return {track: noop}; },
		logMock = noop,
		adProviderNullMock = {
			name: 'Null',
			fillInSlot: noop,
			canHandleSlot: function () {
				return true;
			}
		};

	function mockLazyQueue(startFunction) {
		return {
			makeQueue: function (queue, callback) {
				if (startFunction) {
					queue.start = function () {
						startFunction(callback);
					};
				} else {
					queue.start = noop;
				}
			}
		};
	}

	function mockAdConfig(providerList) {
		return {
			getDecorators: noop,
			getProviderList: function () {
				return providerList || [];
			}
		};
	}

	it('Does not throw with empty queue, but throws with undefined queue', function () {
		var adConfigMock = mockAdConfig(),
			lazyQueueMock = mockLazyQueue(),
			adEngine;

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher);

		expect(function () {
			adEngine.run(adConfigMock, [], 'queue-name');
		}).not.toThrow();

		expect(function () {
			adEngine.run(adConfigMock, undefined, 'queue-name');
		}).toThrow();
	});

	it('Makes LazyQueue from run parameter and starts it', function () {
		var adConfigMock = mockAdConfig(),
			slotsMock,
			lazyQueueMock,
			makeQueueCalledOn,
			queueStartCalled = false,
			adEngine;

		lazyQueueMock = {
			makeQueue: function (queue) {
				makeQueueCalledOn = queue;
			}
		};

		slotsMock = {
			start: function () {
				queueStartCalled = true;
			}
		};

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher);
		adEngine.run(adConfigMock, slotsMock);

		expect(makeQueueCalledOn).toBe(slotsMock, 'Made LazyQueue from the slot array provided to adEngine.run');
		expect(queueStartCalled).toBeTruthy('Called start on the slot array provided to adEngine.run');
	});

	it('Calls AdConfig2 getProviderList canHandleSlot and then fillInSlot for slots provider in the passed array', function () {
		var fakeProvider = {
				name: 'FakeProvider',
				fillInSlot: noop,
				canHandleSlot: noop
			},
			adConfigMock = mockAdConfig([fakeProvider]),
			lazyQueueMock = mockLazyQueue(function (callback) {
				callback(['slot1']);
				callback(['slot2', null, null, 'Provider2']); // the Provider2 should be ignored
			}),
			adEngine;

		spyOn(adConfigMock, 'getProviderList').andCallThrough().andCallThrough();
		spyOn(fakeProvider, 'fillInSlot');
		spyOn(fakeProvider, 'canHandleSlot').andReturn(true);

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher, adProviderNullMock);
		adEngine.run(adConfigMock, []);

		expect(adConfigMock.getProviderList.calls.length).toBe(2, 'adConfig.getProviderList called 2 times');
		expect(adConfigMock.getProviderList.calls[0].args).toEqual(['slot1'], 'adConfig.getProviderList called for slot1');
		expect(adConfigMock.getProviderList.calls[1].args).toEqual(['slot2'], 'adConfig.getProviderList called for slot2');

		expect(fakeProvider.canHandleSlot.calls.length).toBe(2, 'AdProvider*.canHandleSlot called 2 times');
		expect(fakeProvider.canHandleSlot.calls[0].args).toEqual(['slot1'], 'AdProvider*.canHandleSlot called for slot1');
		expect(fakeProvider.canHandleSlot.calls[1].args).toEqual(['slot2'], 'AdProvider*.canHandleSlot called for slot2');

		expect(fakeProvider.fillInSlot.calls.length).toBe(2, 'AdProvider*.fillInSlot called 2 times');
		expect(fakeProvider.fillInSlot.calls[0].args).toEqual(['slot1', jasmine.any(Function), jasmine.any(Function)], 'AdProvider*.fillInSlot called for slot1');
		expect(fakeProvider.fillInSlot.calls[1].args).toEqual(['slot2', jasmine.any(Function), jasmine.any(Function)], 'AdProvider*.fillInSlot called for slot2');
	});

	it('Calls AdConfig2 getProviderList canHandleSlot and not fillInSlot when canHandleSlot = false', function () {
		var fakeProvider = {
				name: 'FakeProvider',
				fillInSlot: noop,
				canHandleSlot: noop
			},
			adConfigMock = mockAdConfig([fakeProvider]),
			lazyQueueMock = mockLazyQueue(function (callback) {
				callback(['slot1']);
				callback(['slot2', null, null, 'Provider2']); // the Provider2 should be ignored
			}),
			adEngine;

		spyOn(adConfigMock, 'getProviderList').andCallThrough();
		spyOn(fakeProvider, 'fillInSlot');
		spyOn(fakeProvider, 'canHandleSlot').andReturn(false);

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher, adProviderNullMock);
		adEngine.run(adConfigMock, []);

		expect(adConfigMock.getProviderList.calls.length).toBe(2, 'adConfig.getProviderList called 2 times');
		expect(adConfigMock.getProviderList.calls[0].args).toEqual(['slot1'], 'adConfig.getProviderList called for slot1');
		expect(adConfigMock.getProviderList.calls[1].args).toEqual(['slot2'], 'adConfig.getProviderList called for slot2');

		expect(fakeProvider.canHandleSlot.calls.length).toBe(2, 'AdProvider*.canHandleSlot called 2 times');
		expect(fakeProvider.canHandleSlot.calls[0].args).toEqual(['slot1'], 'AdProvider*.canHandleSlot called for slot1');
		expect(fakeProvider.canHandleSlot.calls[1].args).toEqual(['slot2'], 'AdProvider*.canHandleSlot called for slot2');

		expect(fakeProvider.fillInSlot.calls.length).toBe(0, 'AdProvider*.fillInSlot called 0 times');
	});

	it('Calls all the provider in the chain and then Null if all of the hop', function () {
		function callHop(slotname, success, hop) {
			hop();
		}

		var fakeProvider1 = {
				name: 'FakeProvider1',
				fillInSlot: noop,
				canHandleSlot: noop
			},
			fakeProvider2 = {
				name: 'FakeProvider2',
				fillInSlot: noop,
				canHandleSlot: noop
			},
			fakeProvider3 = {
				name: 'FakeProvider3',
				fillInSlot: noop,
				canHandleSlot: noop
			},
			fakeNullProvider = {
				name: 'NullProvider',
				fillInSlot: noop,
				canHandleSlot: noop
			},
			adConfigMock = mockAdConfig([fakeProvider1, fakeProvider2, fakeProvider3]),
			lazyQueueMock = mockLazyQueue(function (callback) {
				callback(['slot1']);
			}),
			adEngine;

		spyOn(fakeProvider1, 'fillInSlot').andCallFake(callHop);
		spyOn(fakeProvider2, 'fillInSlot').andCallFake(callHop);
		spyOn(fakeProvider3, 'fillInSlot').andCallFake(callHop);
		spyOn(fakeNullProvider, 'fillInSlot');
		spyOn(fakeProvider1, 'canHandleSlot').andReturn(true);
		spyOn(fakeProvider2, 'canHandleSlot').andReturn(true);
		spyOn(fakeProvider3, 'canHandleSlot').andReturn(true);
		spyOn(fakeNullProvider, 'canHandleSlot').andReturn(true);

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher, fakeNullProvider);
		adEngine.run(adConfigMock, []);

		expect(fakeProvider1.fillInSlot).toHaveBeenCalled();
		expect(fakeProvider2.fillInSlot).toHaveBeenCalled();
		expect(fakeProvider3.fillInSlot).toHaveBeenCalled();
		expect(fakeNullProvider.fillInSlot).toHaveBeenCalled();
	});
});
