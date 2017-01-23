/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker', function () {
	'use strict';

	function noop() {
	}

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker'](
			mocks.adaptersRegistry,
			mocks.prebid,
			mocks.log
		);
	}

	var mocks = {
		adaptersRegistry: {
			getAdapters: function () {
				return [
					{
						getName: function () {
							return 'appnexus'
						}
					},
					{
						getName: function () {
							return 'indexExchange'
						}
					}
				]
			}
		},
		prebid: {
			get: function () {
				return {
					getBidResponsesForAdUnitCode: mocks.getBidResponsesForAdUnitCode
				}
			}
		},
		getBidResponsesForAdUnitCode: noop,
		log: noop
	};

	mocks.log.levels = {};

	it('getSlotBestPrice is calculated correctly', function () {
		[{
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus',
						pbAg: 0
					},
					{
						bidderCode: 'indexExchange',
						pbAg: 0
					}
				]
			},
			expected: {
				appnexus: '0.00',
				indexExchange: '0.00'
			},
			message: 'when adapters offer 0 - 0 is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus',
						pbAg: '0'
					},
					{
						bidderCode: 'indexExchange',
						pbAg: '1'
					}
				]
			},
			expected: {
				appnexus: '0.00',
				indexExchange: '1.00'
			},
			message: 'when adapter returns numeric value as string - correct value is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus',
						pbAg: 0.50
					},
					{
						bidderCode: 'indexExchange',
						pbAg: 0.01
					}
				]
			},
			expected: {
				appnexus: '0.50',
				indexExchange: '0.01'
			},
			message: 'w hen adapter returns fractional value - correct value is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus',
						pbAg: ''
					},
					{
						bidderCode: 'indexExchange',
						pbAg: 1
					}
				]
			},
			expected: {
				appnexus: '',
				indexExchange: '1.00'
			},
			message: 'when one of adapters doesn\'t offer - nothing is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus',
						pbAg: 'something meaningless'
					},
					{
						bidderCode: 'indexExchange',
						pbAg: 100
					}
				]
			},
			expected: {
				appnexus: '',
				indexExchange: '100.00'
			},
			message: 'when incorrect pbAg is set - nothing is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {},
			expected: {
				appnexus: '',
				indexExchange: ''
			},
			message: 'when no bids for slot - nothing is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{}, {}
				]
			},
			expected: {
				appnexus: '',
				indexExchange: ''
			},
			message: 'when bids are empty - nothing is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus'
					}, {
						bidderCode: 'indexExchange'
					}
				]
			},
			expected: {
				appnexus: '',
				indexExchange: ''
			},
			message: 'when bids are set but pbAg is empty - nothing is tracked'
		}].forEach(function (testCase) {
			spyOn(mocks, 'getBidResponsesForAdUnitCode').and.returnValue(testCase.prebidBids);

			var module = getModule(),
				result = module.getSlotBestPrice(testCase.slotName);

			expect(result).toEqual(testCase.expected, testCase.message);

			mocks.getBidResponsesForAdUnitCode = noop;
		});
	});

});
