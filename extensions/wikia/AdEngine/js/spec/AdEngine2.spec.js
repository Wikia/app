describe('AdEngine2', function(){
	it('Throws with undefined queue', function() {
		var logMock = function() {}
			, adConfigMock
			, adslotsNotUsed
			, adEngine
			, lazyQueueMock;

		adEngine = AdEngine2(logMock, lazyQueueMock);

		expect(function() {
			adEngine.run(adConfigMock, adslotsNotUsed);
		}).toThrow();
	});

	it('Makes LazyQueue from run parameter and starts it', function() {
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

		adEngine = AdEngine2(logMock, lazyQueueMock);
		adEngine.run(adConfigMock, slotsMock);

		expect(makeQueueCalledOn).toBe(slotsMock, 'Made LazyQueue from the slot array provided to adEngine.run');
		expect(queueStartCalled).toBeTruthy('Called start on the slot array provided to adEngine.run')
	});

	it('Calls AdConfig2 getProvider and then fillInSlot for slots provider in the passed array', function() {
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

		adEngine = AdEngine2(logMock, lazyQueueMock);
		adEngine.run(adConfigMock, slotsMock);

		expect(getProviderCalledFor.length).toBe(2, 'adConfig.getProvider called 2 times');
		expect(getProviderCalledFor[0]).toBe('slot1', 'adConfig.getProvider called for slot1');
		expect(getProviderCalledFor[1]).toBe('slot2', 'adConfig.getProvider called for slot2');

		expect(fillInSlotCalledFor.length).toBe(2, 'AdProvider*.fillInSlot called 2 times');
		expect(fillInSlotCalledFor[0]).toBe('slot1', 'adConfig.getProvider called for slot1');
		expect(fillInSlotCalledFor[1]).toBe('slot2', 'adConfig.getProvider called for slot2');
	});
});