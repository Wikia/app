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
			getSlotParams: noop,
			getName: function () { return 'amazon'; },
			hasResponse: function () { return true; }
		},
		fastlane: {
			trackState: noop,
			wasCalled: noop,
			getSlotParams: noop,
			getName: function() { return 'rubicon_fastlane'; },
			hasResponse: function () { return true; }
		},
		log: noop,
		oxBidder: {
			trackState: noop,
			wasCalled: noop,
			getSlotParams: noop,
			getName: function () { return 'ox_bidder'; },
			hasResponse: function () { return true; }
		},
		prebid: {
			trackState: noop,
			wasCalled: noop,
			getSlotParams: noop,
			getName: function () { return 'prebid'; },
			hasResponse: function () { return true; }
		},
		vulcan: {
			trackState: noop,
			wasCalled: noop,
			getSlotParams: noop,
			getName: function () { return 'rubicon_vulcan'; },
			hasResponse: function () { return true; }
		},
		window: {}
	};

	it('extends slot targeting for Amazon', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
				mocks.log,
				mocks.amazon
			),
			slotTargetingMock = {a: 'b'},
			expectedSlotTargeting = {
				a: 'b',
				amznslots: ['a1x6p5', 'a3x2p9', 'a7x9p5'],
				bid: 'xxAxx'
			};

		spyOn(mocks.amazon, 'trackState');
		spyOn(mocks.amazon, 'wasCalled').and.returnValue(true);
		spyOn(mocks.amazon, 'getSlotParams').and.returnValue({amznslots: ['a1x6p5', 'a3x2p9', 'a7x9p5']});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock, 'RemnantGpt');
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
		expect(mocks.amazon.trackState).toHaveBeenCalled();
	});

	it('extends slot targeting for OpenX', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
			mocks.log,
			undefined,
			mocks.oxBidder
			),
			slotTargetingMock = {a: 'b'},
			expectedSlotTargeting = {
				a: 'b',
				oxslots: ['ox1x6p5', 'ox3x2p9', 'ox7x9p5'],
				bid: 'xOxxx'
			};

		spyOn(mocks.oxBidder, 'trackState');
		spyOn(mocks.oxBidder, 'wasCalled').and.returnValue(true);
		spyOn(mocks.oxBidder, 'getSlotParams').and.returnValue({oxslots: ['ox1x6p5', 'ox3x2p9', 'ox7x9p5']});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock, 'DirectGpt');
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
		expect(mocks.oxBidder.trackState).toHaveBeenCalled();
	});

	it('extends slot targeting for RubiconFastlane', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
			mocks.log,
			undefined,
			mocks.fastlane
			),
			slotTargetingMock = {a: 'b'},
			expectedSlotTargeting = {
				a: 'b',
				flslots: ['fa1s', 'fa2s', 'fa3s'],
				bid: 'Rxxxx'
			};

		spyOn(mocks.fastlane, 'trackState');
		spyOn(mocks.fastlane, 'wasCalled').and.returnValue(true);
		spyOn(mocks.fastlane, 'getSlotParams').and.returnValue({flslots: ['fa1s', 'fa2s', 'fa3s']});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock, 'DirectGpt');
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
		expect(mocks.fastlane.trackState).toHaveBeenCalled();
	});

	it('extends slot targeting for Prebid.js', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
			mocks.log,
			undefined,
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

	it('extends slot targeting for Rubicon Vulcan', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
			mocks.log,
			undefined,
			mocks.vulcan
			),
			slotTargetingMock = {a: 'b'},
			expectedSlotTargeting = {
				a: 'b',
				vulcanslots: ['va1s', 'va2s', 'va3s'],
				bid: 'xxxVx'
			};

		spyOn(mocks.vulcan, 'trackState');
		spyOn(mocks.vulcan, 'wasCalled').and.returnValue(true);
		spyOn(mocks.vulcan, 'getSlotParams').and.returnValue({vulcanslots: ['va1s', 'va2s', 'va3s']});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock, 'DirectGpt');
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
		expect(mocks.vulcan.trackState).toHaveBeenCalled();
	});

	it('correctly mark all bid slots', function () {
		var lookup = modules['ext.wikia.adEngine.lookup.services'](
			mocks.log,
			mocks.prebid,
			mocks.amazon,
			mocks.oxBidder,
			mocks.fastlane,
			mocks.vulcan
			),
			slotTargetingMock = {a: 'b'},
			expectedSlotTargeting = {
				a: 'b',
				slots: ['va1s', 'va2s', 'va3s'],
				bid: 'ROAVP'
			},
			testedProviders = [mocks.vulcan, mocks.amazon, mocks.prebid, mocks.oxBidder, mocks.fastlane];

		testedProviders.forEach(function(provider) {
			spyOn(provider, 'wasCalled').and.returnValue(true);
			spyOn(provider, 'getSlotParams').and.returnValue({slots: ['va1s', 'va2s', 'va3s']});
		});

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock, 'DirectGpt');
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
	});

});
