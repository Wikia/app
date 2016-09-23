/*global describe,modules,it,expect,spyOn,jasmine*/
/*jshint maxlen:200*/
/*jslint unparam:true*/

describe('ext.wikia.adEngine.adEngine', function () {
	'use strict';

	var eventDispatcher = { trigger: function () { return true; }},
		noop = function () { return; },
		originalLazyQueue = modules['wikia.lazyqueue'](),
		adDecoratorLegacyParamFormatMock = function (fillInSlot) { return fillInSlot; },
		adSlotMock = {
			create: function (slotName, slotElement, callbacks) {
				return {
					name: slotName,
					success: callbacks.success || noop,
					hop: callbacks.hop || noop,
					post: noop
				};
			}
		},
		hooksMock = noop,
		slotTrackerMock = function () { return { track: noop }; },
		slotTweakerMock = {
			show: noop,
			hide: noop,
			isTopLeaderboard: noop
		},
		docMock = {
			getElementById: function () {
				return {
					childNodes: {}
				};
			}
		},
		logMock = noop;

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

	function getAdEngine(lazyQueueMock, adDecoratorMock) {
		return modules['ext.wikia.adEngine.adEngine'](
			adDecoratorMock || adDecoratorLegacyParamFormatMock,
			eventDispatcher,
			adSlotMock,
			slotTrackerMock,
			slotTweakerMock,
			hooksMock,
			docMock,
			lazyQueueMock,
			logMock
		);
	}

	it('Does not throw with empty queue, but throws with undefined queue', function () {
		var adConfigMock = mockAdConfig(),
			lazyQueueMock = mockLazyQueue(),
			adEngine;

		adEngine = getAdEngine(lazyQueueMock);

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

		adEngine = getAdEngine(lazyQueueMock);
		adEngine.run(adConfigMock, slotsMock);

		expect(makeQueueCalledOn).toBe(slotsMock, 'Made LazyQueue from the slot array provided to adEngine.run');
		expect(queueStartCalled).toBeTruthy('Called start on the slot array provided to adEngine.run');
	});

	it(
		'Calls AdConfig2 getProviderList canHandleSlot and then fillInSlot for slots provided in the passed array',
		function () {
			var fakeProvider = {
					name: 'FakeProvider',
					fillInSlot: noop,
					canHandleSlot: noop
				},
				adConfigMock = mockAdConfig([fakeProvider]),
				adEngine,
				adDecoratorLegacyParamFormatMockLocal;

			spyOn(adConfigMock, 'getProviderList').and.callThrough().and.callThrough();
			spyOn(fakeProvider, 'fillInSlot');
			spyOn(fakeProvider, 'canHandleSlot').and.returnValue(true);

			adDecoratorLegacyParamFormatMockLocal = modules['ext.wikia.adEngine.adDecoratorLegacyParamFormat'](logMock);
			adEngine = getAdEngine(originalLazyQueue, adDecoratorLegacyParamFormatMockLocal);
			adEngine.run(adConfigMock, ['slot1', 'slot2']);

			expect(adConfigMock.getProviderList.calls.count()).toBe(2, 'adConfig.getProviderList called 2 times');
			expect(adConfigMock.getProviderList.calls.argsFor(0)).toEqual(
				['slot1'],
				'adConfig.getProviderList called for slot1'
			);
			expect(adConfigMock.getProviderList.calls.argsFor(1)).toEqual(
				['slot2'],
				'adConfig.getProviderList called for slot2'
			);

			expect(fakeProvider.canHandleSlot.calls.count()).toBe(2, 'AdProvider*.canHandleSlot called 2 times');
			expect(fakeProvider.canHandleSlot.calls.argsFor(0)).toEqual(
				['slot1'],
				'AdProvider*.canHandleSlot called for slot1'
			);
			expect(fakeProvider.canHandleSlot.calls.argsFor(1)).toEqual(
				['slot2'],
				'AdProvider*.canHandleSlot called for slot2'
			);

			expect(fakeProvider.fillInSlot.calls.count()).toBe(2, 'AdProvider*.fillInSlot called 2 times');
			expect(fakeProvider.fillInSlot.calls.argsFor(0)[0].name).toEqual(
				'slot1',
				'AdProvider*.fillInSlot called for slot1'
			);
			expect(fakeProvider.fillInSlot.calls.argsFor(1)[0].name).toEqual(
				'slot2',
				'AdProvider*.fillInSlot called for slot2'
			);
		}
	);

	it('Calls AdConfig2 getProviderList canHandleSlot and not fillInSlot when canHandleSlot = false', function () {
		var fakeProvider = {
				name: 'FakeProvider',
				fillInSlot: noop,
				canHandleSlot: noop
			},
			adConfigMock = mockAdConfig([fakeProvider]),
			lazyQueueMock = mockLazyQueue(function (callback) {
				callback({slotName: 'slot1'});
				callback({slotName: 'slot2'});
			}),
			adEngine;

		spyOn(adConfigMock, 'getProviderList').and.callThrough();
		spyOn(fakeProvider, 'fillInSlot');
		spyOn(fakeProvider, 'canHandleSlot').and.returnValue(false);

		adEngine = getAdEngine(lazyQueueMock);
		adEngine.run(adConfigMock, []);

		expect(adConfigMock.getProviderList.calls.count()).toBe(2, 'adConfig.getProviderList called 2 times');
		expect(adConfigMock.getProviderList.calls.argsFor(0)).toEqual(['slot1'], 'adConfig.getProviderList called for slot1');
		expect(adConfigMock.getProviderList.calls.argsFor(1)).toEqual(['slot2'], 'adConfig.getProviderList called for slot2');

		expect(fakeProvider.canHandleSlot.calls.count()).toBe(2, 'AdProvider*.canHandleSlot called 2 times');
		expect(fakeProvider.canHandleSlot.calls.argsFor(0)).toEqual(['slot1'], 'AdProvider*.canHandleSlot called for slot1');
		expect(fakeProvider.canHandleSlot.calls.argsFor(1)).toEqual(['slot2'], 'AdProvider*.canHandleSlot called for slot2');

		expect(fakeProvider.fillInSlot.calls.count()).toBe(0, 'AdProvider*.fillInSlot called 0 times');
	});

	it('Calls all the provider in the chain and then hides the slot if all of the hop', function () {
		function callHop(slot) {
			slot.hop();
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
			adConfigMock = mockAdConfig([fakeProvider1, fakeProvider2, fakeProvider3]),
			adEngine;

		spyOn(fakeProvider1, 'fillInSlot').and.callFake(callHop);
		spyOn(fakeProvider2, 'fillInSlot').and.callFake(callHop);
		spyOn(fakeProvider3, 'fillInSlot').and.callFake(callHop);
		spyOn(slotTweakerMock, 'hide');
		spyOn(fakeProvider1, 'canHandleSlot').and.returnValue(true);
		spyOn(fakeProvider2, 'canHandleSlot').and.returnValue(true);
		spyOn(fakeProvider3, 'canHandleSlot').and.returnValue(true);

		adEngine = getAdEngine(originalLazyQueue);
		adEngine.run(adConfigMock, [{slotName: 'slot1'}]);

		expect(fakeProvider1.fillInSlot).toHaveBeenCalled();
		expect(fakeProvider2.fillInSlot).toHaveBeenCalled();
		expect(fakeProvider3.fillInSlot).toHaveBeenCalled();
		expect(slotTweakerMock.hide).toHaveBeenCalled();
	});
});
