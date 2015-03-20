/*global describe, it, modules, expect, spyOn*/
describe('Method ext.wikia.adEngine.lookup.services', function () {
	'use strict';

	var mocks;

	function noop() {
		return;
	}

	mocks = {
		amazon: {
			trackState: noop,
			wasCalled: noop,
			getPageParams: noop,
			getSlotParams: noop
		},
		log: noop,
		rtp: {
			trackState: noop,
			wasCalled: noop,
			getConfig: noop,
			getTier: noop
		},
		window: {}
	};

	it('extends slot targeting for Rubicon', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
				mocks.log,
				mocks.window,
				undefined,
				undefined,
				mocks.rtp
			),
			slotTargetingMock = {},
			expectedSlotTargeting = { 'rp_tier': 6 };

		spyOn(mocks.rtp, 'wasCalled').and.returnValue(true);
		spyOn(mocks.rtp, 'getConfig').and.returnValue({slotname: ['TOP_LEADERBOARD']});
		spyOn(mocks.rtp, 'getTier').and.returnValue(6);

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock);
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
	});

	it('extends slot targeting for Amazon', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
				mocks.log,
				mocks.window,
				mocks.amazon
			),
			slotTargetingMock = {a: 'b'},
			expectedPageTargeting = {
				a: 'b',
				amznslots: ['a1x6p5', 'a3x2p9', 'a7x9p5']
			};

		spyOn(mocks.amazon, 'wasCalled').and.returnValue(true);
		spyOn(mocks.amazon, 'getSlotParams').and.returnValue({amznslots: ['a1x6p5', 'a3x2p9', 'a7x9p5']});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock);
		expect(slotTargetingMock).toEqual(expectedPageTargeting);
	});
});
