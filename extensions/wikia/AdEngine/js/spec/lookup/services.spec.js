/*global describe, it, modules, expect, spyOn*/
describe('Method ext.wikia.adEngine.lookup.services', function () {
	'use strict';

	var mocks;

	function noop() {
		return;
	}

	mocks = {
		a9: {
			trackState: noop,
			wasCalled: noop,
			getSlotParams: noop,
			getName: function () { return 'a9'; },
			hasResponse: function () { return true; }
		},
		log: noop,
		prebid: {
			trackState: noop,
			wasCalled: noop,
			getSlotParams: noop,
			getBestSlotPrice: function() { return { aol: '0.00' }; },
			getName: function () { return 'prebid'; },
			hasResponse: function () { return true; }
		},
		window: {}
	};

	it('extends slot targeting for A9', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
				mocks.log,
				undefined,
				mocks.a9
			),
			slotTargetingMock = {
				a: 'b'
			},
			expectedSlotTargeting = {
				a: 'b',
				amznbid: 'bid',
				amzniid: 'iid',
				amznsz: 'sz',
				amznp: 'p',
				bid: 'xx9xx'
			};

		spyOn(mocks.a9, 'trackState');
		spyOn(mocks.a9, 'wasCalled').and.returnValue(true);
		spyOn(mocks.a9, 'getSlotParams').and.returnValue({
			amznbid: 'bid',
			amzniid: 'iid',
			amznsz: 'sz',
			amznp: 'p'
		});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock, 'RemnantGpt');
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
		expect(mocks.a9.trackState).toHaveBeenCalled();
	});

	it('extends slot targeting for Prebid.js', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
			mocks.log,
			mocks.prebid
			),
			slotTargetingMock = {a: 'b'},
			expectedSlotTargeting = {
				a: 'b',
				prebidslots: ['pa1s', 'pa2s', 'pa3s'],
				bid: 'xxxxP'
			};

		spyOn(mocks.prebid, 'trackState');
		spyOn(mocks.prebid, 'wasCalled').and.returnValue(true);
		spyOn(mocks.prebid, 'getSlotParams').and.returnValue({prebidslots: ['pa1s', 'pa2s', 'pa3s']});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock, 'DirectGpt');
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
		expect(mocks.prebid.trackState).toHaveBeenCalled();
	});

});
