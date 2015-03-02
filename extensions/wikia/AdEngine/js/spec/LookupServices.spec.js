describe('Method ext.wikia.adEngine.lookupServices', function () {
	'use strict';

	var logMock = function () { return; },
		winMock = {},
		rtpMock = {
			trackState: function () { return; },
			wasCalled: function () { return true; },
			getConfig: function () {
				return { slotname: ['TOP_LEADERBOARD'] };
			},
			getTier: function () {
				return 6;
			}
		};

	it('extends slot targeting for Rubicon', function () {
		var lookup = modules['ext.wikia.adEngine.lookupServices'](
				logMock,
				winMock,
				rtpMock
			),
			slotTargetingMock = {},
			expectedSlotTargeting = { 'rp_tier': 6 };

		lookup.extendSlotTargeting('TOP_LEADERBOARD', slotTargetingMock);
		expect(slotTargetingMock).toEqual(expectedSlotTargeting);
	});

	xit('extends page targeting for Amazon', function () {
		var amazonMatch = modules['ext.wikia.adEngine.amazonMatch']({}, {}, {}, {}),
			lookup = modules['ext.wikia.adEngine.lookupServices'](
				logMock,
				winMock,
				undefined,
				amazonMatch
			),
			pageTargetingMock = {},
			expectedPageTargeting = {
				amznslots: ['a1x6p5', 'a3x2p9', 'a7x9p5']
			};

		spyOn(amazonMatch, 'trackState').stub();
		spyOn(amazonMatch, 'wasCalled').returnValue(true);
		spyOn(amazonMatch, 'getPageParams').returnValue({
			amznslots: ['a7x9p5', 'a7x9p11', 'a1x6p6', 'a1x6p5', 'a3x2p9', 'a1x6p14', 'a7x9p6', 'a3x2p14']
		});
		spyOn(amazonMatch, 'filterSlots').andCallThrough();

		lookup.extendPageTargeting(pageTargetingMock);
		expect(pageTargetingMock).toEqual(expectedPageTargeting);
	});
});
