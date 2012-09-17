/*!
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdEngine2.js
 */

module('AdEngine2');

test('Throws with undefined queue', function() {
	var logMock = function() {}
		, adConfigMock
		, lazyQueueMock
		, adEngine;

	adEngine = AdEngine2(adConfigMock, logMock, lazyQueueMock);

	throws(function() {
		adEngine.run(adslotsNotUsed);
	}, 'Throws exception');
});

test('Makes LazyQueue from run parameter and starts it', function() {
	var logMock = function() {}
		, adConfigMock
		, slotsMock
		, lazyQueueMock
		, makeQueueCalledOn
		, queueStartCalled = false
		, adEngine;

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

	adEngine = AdEngine2(adConfigMock, logMock, lazyQueueMock);
	adEngine.run(slotsMock);

	equal(makeQueueCalledOn, slotsMock, 'Made LazyQueue from the slot array provided to adEngine.run');
	equal(queueStartCalled, true, 'Called start on the slot array provided to adEngine.run')
});

test('Calls AdConfig2 getProvider and then fillInSlot for slots provider in the passed array', function() {
	var logMock = function() {}
		, adConfigMock
		, slotsMock = {start: function() {}}
		, lazyQueueMock
		, getProviderCalledFor = []
		, fillInSlotCalledFor = []
		, adEngine;

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
				fillInSlot: function() {
					fillInSlotCalledFor.push(slot[0]);
				}
			}
		}
	};

	adEngine = AdEngine2(adConfigMock, logMock, lazyQueueMock);
	adEngine.run(slotsMock);

	equal(getProviderCalledFor.length, 2, 'adConfig.getProvider called 2 times');
	equal(getProviderCalledFor[0], 'slot1', 'adConfig.getProvider called for slot1');
	equal(getProviderCalledFor[1], 'slot2', 'adConfig.getProvider called for slot2');

	equal(fillInSlotCalledFor.length, 2, 'AdProvider*.fillInSlot called 2 times');
	equal(fillInSlotCalledFor[0], 'slot1', 'adConfig.getProvider called for slot1');
	equal(fillInSlotCalledFor[1], 'slot2', 'adConfig.getProvider called for slot2');
});
