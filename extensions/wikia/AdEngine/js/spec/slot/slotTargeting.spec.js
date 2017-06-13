/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.slotTargeting', function () {
	'use strict';

	var mocks = {
		pbjs: {
			getAdserverTargetingForAdUnitCode: noop
		}
	};

	function noop() {}

	function getModule(pageType, skin) {
		var abTest = {
				getExperiments: function () {
					return [
						{
							id: 1,
							group: {
								id: 15
							}
						},
						{
							id: 5,
							group: {
								id: 21
							}
						}
					];
				}
			},
			adContext = {
				getContext: function() {
					return {
						targeting: {
							pageType: pageType,
							skin: skin
						}
					};
				}
			},
			instantGlobals = {
				wgAdDriverAbTestIdTargeting: 1
			},
			prebid = {
				get: function () {
					return mocks.pbjs;
				}
			};

		return modules['ext.wikia.adEngine.slot.slotTargeting'](
			adContext,
			modules['ext.wikia.adEngine.utils.math'](),
			prebid,
			abTest,
			instantGlobals
		);
	}

	it('Generate correct wikia slot id', function () {
		var testCases = [
			{
				env: {
					pageType: 'article',
					skin: 'oasis',
					src: 'remnant',
					slotName: 'TOP_RIGHT_BOXAD'
				},
				wsi: 'oma2'
			},
			{
				env: {
					pageType: 'article',
					skin: 'oasis',
					src: 'rec',
					slotName: 'TOP_LEADERBOARD'
				},
				wsi: 'olar'
			},
			{
				env: {
					pageType: 'article',
					skin: 'oasis',
					src: 'premium',
					slotName: 'INCONTENT_PLAYER'
				},
				wsi: 'oiap'
			},
			{
				env: {},
				wsi: 'xxxx'
			},
			{
				env: {
					pageType: 'home'
				},
				wsi: 'xxhx'
			},
			{
				env: {
					pageType: 'article'
				},
				wsi: 'xxax'
			},
			{
				env: {
					pageType: 'undefined'
				},
				wsi: 'xxxx'
			},
			{
				env: {
					skin: 'oasis'
				},
				wsi: 'oxxx'
			},
			{
				env: {
					skin: 'mercury'
				},
				wsi: 'mxxx'
			},
			{
				env: {
					skin: 'undefined'
				},
				wsi: 'xxxx'
			},
			{
				env: {
					src: 'remnant'
				},
				wsi: 'xxx2'
			},
			{
				env: {
					src: 'gpt'
				},
				wsi: 'xxx1'
			},
			{
				env: {
					src: 'rec'
				},
				wsi: 'xxxr'
			},
			{
				env: {
					src: 'premium'
				},
				wsi: 'xxxp'
			},
			{
				env: {
					src: 'undefined'
				},
				wsi: 'xxxx'
			},
			{
				env: {
					slotName: 'TOP_LEADERBOARD'
				},
				wsi: 'xlxx'
			},
			{
				env: {
					slotName: 'MOBILE_BOTTOM_LEADERBOARD'
				},
				wsi: 'xbxx'
			},
			{
				env: {
					slotName: 'undefined'
				},
				wsi: 'xxxx'
			}
		];

		testCases.forEach(function (testCase) {
			var slotTargeting = getModule(testCase.env.pageType, testCase.env.skin),
				wsi = slotTargeting.getWikiaSlotId(testCase.env.slotName, testCase.env.src);

			expect(wsi).toBe(testCase.wsi);
		});
	});

	it('Generate correct prebid slot id', function () {
		var testCases = [
			{
				data: {
					hb_bidder: 'veles',
					hb_size: '640x480',
					hb_pb: '16.50',
					wsi: 'ola1'
				},
				hb_si: 've640x480t1650ol'
			},
			{
				data: {
					hb_bidder: 'rubicon',
					hb_size: '640x480',
					hb_pb: '7.25',
					wsi: 'mia1'
				},
				hb_si: 'ru640x480t0725mi'
			},
			{
				data: {
					hb_bidder: 'aol',
					hb_size: '300x250',
					hb_pb: '0.01',
					wsi: 'oph2'
				},
				hb_si: 'ao300x250t0001op'
			}
		];

		testCases.forEach(function (testCase) {
			var slotTargeting = getModule(),
				hbSi = slotTargeting.getPrebidSlotId(testCase.data);

			expect(hbSi).toBe(testCase.hb_si);
		});
	});

	it('Generate correct ab slot id', function () {
		var abi = getModule().getAbTestId({
			wsi: 'ola1'
		});

		expect(abi).toBe('1_15ola1');
	});

	it('Generate correct outstream value', function () {
		var testCases = [
				{
					targeting: {
						hb_bidder: 'veles',
						hb_pb: '13.00'
					},
					outstream: 've1300'
				},
				{
					targeting: {
						hb_bidder: 'veles',
						hb_pb: '00.00'
					},
					outstream: 've0000'
				},
				{
					targeting: {
						hb_bidder: 'vulcan',
						hb_pb: '0000'
					},
					outstream: 'vu0000'
				},
				{
					targeting: {
						hb_bidder: 'vulcan',
						hb_pb: '12.50'
					},
					outstream: 'vu1250'
				},
                {
                    targeting: {
                        hb_bidder: 'indexExchange',
                        hb_pb: '12.50'
                    },
                    outstream: undefined
                },
                {
                    targeting: {
                        hb_bidder: 'indexExchange'
                    },
                    outstream: undefined
                }
			],
			getAdserverTargetingForAdUnitCodeSpy = spyOn(mocks.pbjs, 'getAdserverTargetingForAdUnitCode');

		testCases.forEach(function (testCase) {
			var slotTargeting = getModule('article', 'oasis'),
				outstream;

			getAdserverTargetingForAdUnitCodeSpy.and.returnValue(testCase.targeting);
			outstream = slotTargeting.getOutstreamData();

			expect(outstream).toBe(testCase.outstream);
		});
	});
});
