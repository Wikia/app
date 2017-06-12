describe('ext.wikia.adEngine.adInfoTrackerHelper', function () {
	'use strict';

	function noop() {}

	var mocks = {
		lookupServices: {
			getCurrentSlotPrices: function() {
				return {};
			},
			getDfpSlotPrices: function () {
				return {};
			}
		},
		adBlockDetection: {
			isBlocking: noop
		},
		window: {},
		log: noop
	}, fakeJSONString = JSON.stringify({foo: 1});

	function getModule() {
		return modules['ext.wikia.adEngine.adInfoTrackerHelper'](
			mocks.lookupServices,
			mocks.adBlockDetection,
			mocks.log,
			mocks.window
		);
	}

	mocks.log.levels = {};

	function getTopLeaderboardSlotWithPageParams(gptPageParams) {
		var container = document.createElement('div'),
			firstChild = document.createElement('div'),
			slot = document.createElement('div');

		if (gptPageParams) {
			firstChild.dataset.gptPageParams = gptPageParams;
		}
		container.appendChild(firstChild);
		slot.container = container;
		slot.name = 'TOP_LEADERBOARD';

		return slot;
	}

	it('shouldHandleSlot be true if slot is enabled, has gptPageParams and user does not block ads', function () {
		var enabledSlots = {
				TOP_LEADERBOARD: true,
				TOP_RIGHT_BOXAD: true
			};

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(false);

		expect(getModule().shouldHandleSlot(getTopLeaderboardSlotWithPageParams(fakeJSONString), enabledSlots)).toBeTruthy();
	});

	it('shouldHandleSlot be false if slot is not enabled, has gptPageParams and user does not block ads', function () {
		var enabledSlots = {
			TOP_RIGHT_BOXAD: true
		};

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(false);

		expect(getModule().shouldHandleSlot(getTopLeaderboardSlotWithPageParams(fakeJSONString), enabledSlots)).toBeFalsy();
	});

	it('shouldHandleSlot be false if slot is enabled, has no gptPageParams div and user does not block ads', function () {
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

	it('shouldHandleSlot be false if slot is enabled, has no gptPageParams and user does not block ads', function () {
		var enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true
		};

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(false);

		expect(getModule().shouldHandleSlot(getTopLeaderboardSlotWithPageParams(), enabledSlots)).toBeFalsy();
	});

	it('shouldHandleSlot be false if slot is enabled, has gptPageParams and user blocks ads', function () {
		var enabledSlots = {
			TOP_LEADERBOARD: true,
			TOP_RIGHT_BOXAD: true
		};

		spyOn(mocks.adBlockDetection, 'isBlocking');
		mocks.adBlockDetection.isBlocking.and.returnValue(true);

		expect(getModule().shouldHandleSlot(getTopLeaderboardSlotWithPageParams(fakeJSONString), enabledSlots)).toBeFalsy();
	});

	it('prepareData correctly parses gptPageParams', function () {
		var data,
			slot = getTopLeaderboardSlotWithPageParams(fakeJSONString);

		slot.container.firstChild.dataset.gptSlotParams = fakeJSONString;
		slot.container.firstChild.dataset.gptCreativeSize = fakeJSONString;

		data = getModule().prepareData(slot);

		expect(data.pv).toBe('');
		expect(data.country).toBe('');
		expect(data.kv_s0).toBe('');
		expect(data.kv_s1).toBe('');
		expect(data.kv_s2).toBe('');
		expect(data.kv_s0v).toBe('');
		expect(data.kv_lang).toBe('');
		expect(data.kv_skin).toBe('');
		expect(data.kv_esrb).toBe('');
		expect(data.kv_ref).toBe('');
		expect(data.kv_top).toBe('');
		expect(data.kv_ah).toBe('');
	});

	it('prepareData correctly fallback if gptPageParams are not filled', function () {
		var data,
			slot = getTopLeaderboardSlotWithPageParams(JSON.stringify({
				pv: 33,
				geo: 'pl',
				s0: 's0',
				s1: 's1',
				s2: 's2',
				s0v: 's0v',
				lang: 'pl',
				skin: 'oasis',
				esrb: 'esrb',
				ref: 'ref',
				top: 'top',
				ah: 'ah'
			}));

		slot.container.firstChild.dataset.gptSlotParams = fakeJSONString;
		slot.container.firstChild.dataset.gptCreativeSize = fakeJSONString;

		data = getModule().prepareData(slot);

		expect(data.pv).toBe(33);
		expect(data.country).toBe('pl');
		expect(data.kv_s0).toBe('s0');
		expect(data.kv_s1).toBe('s1');
		expect(data.kv_s2).toBe('s2');
		expect(data.kv_s0v).toBe('s0v');
		expect(data.kv_lang).toBe('pl');
		expect(data.kv_skin).toBe('oasis');
		expect(data.kv_esrb).toBe('esrb');
		expect(data.kv_ref).toBe('ref');
		expect(data.kv_top).toBe('top');
		expect(data.kv_ah).toBe('ah');
	});

	it('prepareData correctly calculates bidder_won for no bidders', function () {
		var data,
			slot = getTopLeaderboardSlotWithPageParams(fakeJSONString);

		slot.container.firstChild.dataset.gptSlotParams = fakeJSONString;
		slot.container.firstChild.dataset.gptCreativeSize = fakeJSONString;

		data = getModule().prepareData(slot);

		expect(data.bidder_won).toBe('');
	});

	it('prepareData correctly calculates bidder_won for bidders - fastlane_private', function () {
		var data,
			slot = getTopLeaderboardSlotWithPageParams(fakeJSONString);

		slot.container.firstChild.dataset.gptSlotParams = JSON.stringify(fakeJSONString);
		slot.container.firstChild.dataset.gptCreativeSize = fakeJSONString;

		mocks.lookupServices.getDfpSlotPrices = function() {
			return {
				fastlane_private: '2.50',
				openx: '1.30',
				rubicon: '0.75'
			};
		};

		data = getModule().prepareData(slot);

		expect(data.bidder_won).toBe('fastlane_private');
	});

	it('prepareData correctly calculates bidder_won for bidders - openx', function () {
		var data,
			slot = getTopLeaderboardSlotWithPageParams(fakeJSONString);

		slot.container.firstChild.dataset.gptSlotParams = JSON.stringify(fakeJSONString);
		slot.container.firstChild.dataset.gptCreativeSize = fakeJSONString;

		mocks.lookupServices.getDfpSlotPrices = function() {
			return {
				fastlane_private: '2.50',
				openx: '3.30',
				rubicon: '0.75'
			};
		};

		data = getModule().prepareData(slot);


		expect(data.bidder_won).toBe('openx');
	});
});
