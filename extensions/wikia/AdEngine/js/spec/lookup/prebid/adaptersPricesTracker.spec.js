/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker', function () {
	'use strict';

	function noop() {
	}

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.adaptersPricesTracker'](
			mocks.adaptersRegistry,
			mocks.bidHelper,
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
		bidHelper: {
			transformPriceFromBid: function(bid) {
				return bid.cpm;
			}
		},
		prebid: {
			get: function () {
				return {
					getBidResponsesForAdUnitCode: mocks.getBidResponsesForAdUnitCode,
				}
			},
			validResponseStatusCode: 1,
			errorResponseStatusCode: 2
		},
		getBidResponsesForAdUnitCode: noop,
		getStatusCodeValid: function() {
			return 1;
		},
		getStatusCodeInvalid: function() {
			return 2;
		},
		log: noop
	};

	mocks.log.levels = {};

	it('isValidPrice is calculated correctly', function () {
		[
			{
				getStatusCode: mocks.getStatusCodeValid,
				expected: true
			},
			{
				getStatusCode: mocks.getStatusCodeInvalid,
				expected: false
			}
		].forEach(function (testCase) {
			var module = getModule(),
				result = module._isValidPrice(testCase);

			expect(result).toEqual(testCase.expected, testCase.message);
		});
	});

	it('getSlotBestPrice is calculated correctly', function () {
		[{
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus',
						cpm: 0,
						getStatusCode: mocks.getStatusCodeValid
					},
					{
						bidderCode: 'indexExchange',
						cpm: 0,
						getStatusCode: mocks.getStatusCodeValid
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
						cpm: 0.50,
						getStatusCode: mocks.getStatusCodeValid
					},
					{
						bidderCode: 'indexExchange',
						cpm: 0.01,
						getStatusCode: mocks.getStatusCodeValid
					}
				]
			},
			expected: {
				appnexus: '0.50',
				indexExchange: '0.01'
			},
			message: 'when adapter returns fractional value - correct value is tracked'
		}, {
			slotName: 'TOP_LEADERBOARD',
			prebidBids: {
				bids: [
					{
						bidderCode: 'appnexus',
						cpm: 0,
						getStatusCode: mocks.getStatusCodeInvalid
					},
					{
						bidderCode: 'indexExchange',
						cpm: 1,
						getStatusCode: mocks.getStatusCodeValid
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
		}].forEach(function (testCase) {
			spyOn(mocks, 'getBidResponsesForAdUnitCode').and.returnValue(testCase.prebidBids);

			var module = getModule(),
				result = module.getSlotBestPrice(testCase.slotName);

			expect(result).toEqual(testCase.expected, testCase.message);

			mocks.getBidResponsesForAdUnitCode = noop;
		});
	});

});
