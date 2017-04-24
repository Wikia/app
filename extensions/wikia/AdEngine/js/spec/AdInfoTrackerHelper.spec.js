describe('ext.wikia.adEngine.adInfoTrackerHelper', function () {
	'use strict';

	function noop() {}

	var mocks = {
		lookupServices: {},
		adBlockDetection: {
			isBlocking: noop
		},
		window: {},
		log: noop
	};

	function getModule() {
		return modules['ext.wikia.adEngine.adInfoTrackerHelper'](
			mocks.lookupServices,
			mocks.adBlockDetection,
			mocks.log,
			mocks.window
		);
	}

	mocks.log.levels = {};

	function getTopLeaderboardSlotWithContainer() {
		var container = document.createElement('div'),
			firstChild = document.createElement('div'),
			slot = document.createElement('div');

		firstChild.dataset.gptPageParams = '{foo: 1}';
		container.appendChild(firstChild);
		slot.container = container;
		slot.name = 'TOP_LEADERBOARD';

		return slot;
	}

	it('shouldHandleSlot is true if slot is enabled, has gptPageParams and user does not block ads', function () {
		var enabledSlots = {
				TOP_LEADERBOARD: true,
				TOP_RIGHT_BOXAD: true
			};

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(false);

		expect(getModule().shouldHandleSlot(getTopLeaderboardSlotWithContainer(), enabledSlots)).toBeTruthy();
	});

	it('shouldHandleSlot is false if slot is not enabled, has gptPageParams and user does not block ads', function () {
		var enabledSlots = {
			TOP_RIGHT_BOXAD: true
		};

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(false);

		expect(getModule().shouldHandleSlot(getTopLeaderboardSlotWithContainer(), enabledSlots)).toBeFalsy();
	});

	it('shouldHandleSlot is false if slot is enabled, has no gptPageParams div and user does not block ads', function () {
		var enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true
		}, slot = document.createElement('div');

		slot.container = document.createElement('div');
		slot.name = 'TOP_LEADERBOARD';

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(false);

		expect(getModule().shouldHandleSlot(slot, enabledSlots)).toBeFalsy();
	});

	it('shouldHandleSlot is false if slot is enabled, has no gptPageParams and user does not block ads', function () {
		var enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true
		}, slot = document.createElement('div'),
			firstChild = document.createElement('div');

		slot.container = document.createElement('div');
		slot.container.appendChild(firstChild);
		slot.name = 'TOP_LEADERBOARD';

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(false);

		expect(getModule().shouldHandleSlot(slot, enabledSlots)).toBeFalsy();
	});

	it('shouldHandleSlot is false if slot is enabled, has gptPageParams and user blocks ads', function () {
		var enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true
		};

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(true);

		expect(getModule().shouldHandleSlot(getTopLeaderboardSlotWithContainer(), enabledSlots)).toBeFalsy();
	});
});
