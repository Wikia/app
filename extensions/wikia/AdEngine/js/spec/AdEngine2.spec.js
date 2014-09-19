/*global describe,modules,it,expect */
describe('AdEngine2', function(){
	'use strict';
	var eventDispatcher = { trigger: function() { return true; }};

	it('Doesn\'t throw with empty queue, but throws with undefined queue', function() {
		var logMock = function() {},
			adConfigMock = {getDecorators: function () {}},
			lazyQueueMock = {makeQueue: function (queue) {queue.start = function() {}}},
			slotTrackerMock,
			adEngine,
			undef;

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher);

		expect(function() {
			adEngine.run(adConfigMock, [], 'queue-name');
		}).not.toThrow();

		expect(function() {
			adEngine.run(adConfigMock, undef, 'queue-name');
		}).toThrow();
	});

	it('Makes LazyQueue from run parameter and starts it', function() {
		var logMock = function() {},
			adConfigMock = {getDecorators: function () {}},
			slotsMock,
			lazyQueueMock,
			slotTrackerMock,
			makeQueueCalledOn,
			queueStartCalled = false,
			adEngine;

		lazyQueueMock = {
			makeQueue: function(queue, callback) {
				makeQueueCalledOn = queue;
			}
		};

		slotsMock = {
			start: function() {
				queueStartCalled = true;
			}
		};

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher);
		adEngine.run(adConfigMock, slotsMock);

		expect(makeQueueCalledOn).toBe(slotsMock, 'Made LazyQueue from the slot array provided to adEngine.run');
		expect(queueStartCalled).toBeTruthy('Called start on the slot array provided to adEngine.run');
	});

	it('Calls AdConfig2 getProvider and then fillInSlot for slots provider in the passed array', function() {
		var noop = function () {},
			logMock = noop,
			adConfigMock,
			slotsMock = {start: noop},
			lazyQueueMock,
			slotTrackerMock = function () { return {init: noop, success: noop, hop: noop}; },
			getProviderCalledFor = [],
			fillInSlotCalledFor = [],
			adEngine;

		lazyQueueMock = {
			makeQueue: function(slots, callback) {
				callback(['slot1', 'ProviderName']);
				callback(['slot2', 'ProviderName']);
			}
		};

		adConfigMock = {
			getProvider: function(slot) {
				getProviderCalledFor.push(slot[0]);
				return {
					fillInSlot: function(slotname) {
						fillInSlotCalledFor.push(slotname);
					}
				};
			},
			getDecorators: noop
		};

		adEngine = modules['ext.wikia.adEngine.adEngine'](logMock, lazyQueueMock, slotTrackerMock, eventDispatcher);
		adEngine.run(adConfigMock, slotsMock);

		expect(getProviderCalledFor.length).toBe(2, 'adConfig.getProvider called 2 times');
		expect(getProviderCalledFor[0]).toBe('slot1', 'adConfig.getProvider called for slot1');
		expect(getProviderCalledFor[1]).toBe('slot2', 'adConfig.getProvider called for slot2');

		expect(fillInSlotCalledFor.length).toBe(2, 'AdProvider*.fillInSlot called 2 times');
		expect(fillInSlotCalledFor[0]).toBe('slot1', 'adConfig.getProvider called for slot1');
		expect(fillInSlotCalledFor[1]).toBe('slot2', 'adConfig.getProvider called for slot2');
	});
});
