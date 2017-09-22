/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
			adTracker: {
				track: noop
			},
			prebid: {
				get: function () {
					return mocks.pbjs;
				},
				validResponseStatusCode: 1,
				errorResponseStatusCode: 2
			},
			timeBuckets: {
				getTimeBucket: function () {
					return '0-1.0';
				}
			},
			adapterAppNexus: {
				getName: function () {
					return 'appnexus';
				},
				isEnabled: function () {
					return true;
				},
				getSlots: function () {
					return {
						TOP_LEADERBOARD: {
							sizes: [
								[728, 90],
								[970, 250]
							]
						},
						TOP_RIGHT_BOXAD: {
							sizes: [
								[300, 250],
								[300, 600]
							]
						}
					};
				}
			},
			adapterIndexExchange: {
				getName: function () {
					return 'indexExchange';
				},
				isEnabled: function () {
					return true;
				},
				getSlots: function () {
					return {
						TOP_LEADERBOARD: {
							sizes: [
								[728, 90],
								[970, 250]
							]
						}
					};
				}
			},
			adapterIndexExchangeEmpty: {
				getName: function () {
					return 'indexExchange';
				},
				isEnabled: function () {
					return true;
				},
				getSlots: function () {
					return {};
				}
			},
			adapterIndexExchangeDisabled: {
				getName: function () {
					return 'indexExchange';
				},
				isEnabled: function () {
					return false;
				},
				getSlots: function () {
					return {
						TOP_LEADERBOARD: {
							sizes: [
								[728, 90],
								[970, 250]
							]
						}
					};
				}
			},
			correctIndexExchangeBid: {
				bidder: 'indexExchange',
				cpm: '1.00',
				getStatusCode: function () {
					return 1;
				},
				getSize: function () {
					return '200x200';
				}
			},
			correctAppNexusBid: {
				bidder: 'appnexus',
				cpm: '0.00',
				getStatusCode: function () {
					return 1;
				},
				getSize: function () {
					return '100x100';
				}
			},
			completeAppNexusBid: {
				bidder: 'appnexus',
				complete: true,
				cpm: '5.00',
				getStatusCode: function () {
					return 1;
				},
				getSize: function () {
					return '100x100';
				}
			},
			emptyAppNexusBid: {
				bidder: 'appnexus',
				getStatusCode: function () {
					return 2;
				}
			},
			pbjs: {
				getBidResponses: noop
			},
			adaptersRegistry: {
				getAdapters: noop
			},
			bidHelper: {
				transformPriceFromBid: function(bid) {
					return bid.cpm;
				}
			}
		},
		module,
		getBidResponsesSpy,
		getAdaptersSpy;

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker'](
			mocks.adTracker,
			mocks.adaptersRegistry,
			mocks.bidHelper,
			mocks.timeBuckets,
			mocks.prebid
		);
	}

	beforeEach(function () {
		getAdaptersSpy = spyOn(mocks.adaptersRegistry, 'getAdapters');
		module = getModule();
		getBidResponsesSpy = spyOn(mocks.pbjs, 'getBidResponses');
	});

	it('setupPerformanceMap creates object with correct structure', function () {
		[{
			skin: 'oasis',
			adapters: [],
			expected: {},
			message: 'empty map returned if there are no adapters'
		}, {
			skin: 'oasis',
			adapters: [
				mocks.adapterAppNexus
			],
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				}
			},
			message: 'map is correctly initiated if only one adapter is added'
		}, {
			skin: 'oasis',
			adapters: [
				mocks.adapterAppNexus,
				mocks.adapterIndexExchange
			],
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			message: 'map is correctly initiated if two adapters are added'
		}, {
			skin: 'oasis',
			adapters: [
				mocks.adapterAppNexus,
				mocks.adapterIndexExchangeDisabled
			],
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				}
			},
			message: 'disabled adapters are not added'
		}, {
			skin: 'oasis',
			adapters: [
				mocks.adapterAppNexus,
				mocks.adapterIndexExchangeEmpty
			],
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {}
			},
			message: 'disabled adapters are not added'
		}].forEach(function (testCase) {
			getAdaptersSpy.and.returnValue(testCase.adapters);
			var result = module.setupPerformanceMap(testCase.skin);

			expect(result).toEqual(testCase.expected, testCase.message);
		});
	});

	it('updatePerformanceMap updates the map structure correctly', function () {
		[{
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			allBids: {},
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			message: 'if no bids are returned map stays untouched'
		}, {
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			allBids: {
				TOP_LEADERBOARD: {
					bids: [
						mocks.correctIndexExchangeBid,
						mocks.correctAppNexusBid
					]
				}
			},
			expected: {
				appnexus: {
					TOP_LEADERBOARD: '100x100;0.00;0-1.0',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00;0-1.0'
				}
			},
			message: 'Only returned bids are updated in map'
		}, {
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			allBids: {
				TOP_LEADERBOARD: {
					bids: [
						mocks.correctIndexExchangeBid,
						mocks.emptyAppNexusBid
					]
				}
			},
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'EMPTY_RESPONSE;0-1.0',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00;0-1.0'
				}
			},
			message: 'if no bids for slot are returned map stays untouched'
		}, {
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NO_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			allBids: {
				TOP_LEADERBOARD: {
					bids: [
						mocks.correctAppNexusBid
					]
				}, TOP_RIGHT_BOXAD: {
					bids: [
						mocks.correctAppNexusBid
					]
				}
			},
			expected: {
				appnexus: {
					TOP_LEADERBOARD: '100x100;0.00;0-1.0',
					TOP_RIGHT_BOXAD: '100x100;0.00;0-1.0'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			message: 'if no bids for one bidder are returned map stays untouched'
		}].forEach(function (testCase) {
			var result;

			getBidResponsesSpy.and.returnValue(testCase.allBids);
			result = module.updatePerformanceMap(testCase.performanceMap);

			expect(result).toEqual(testCase.expected, testCase.message);
		});
	});

	it('trackBidderSlotState does not track when adapter disabled or slot not supported', function () {
		[{
			adapter: mocks.adapterIndexExchangeDisabled,
			slotName: 'TOP_LEADERBOARD',
			providerName: 'direct',
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'EMPTY_RESPONSE;0-1.0',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00;0-1.0'
				}
			},
			expected: undefined,
			message: 'Return undefined when adapter is disabled'
		}, {
			adapter: mocks.adapterIndexExchange,
			slotName: 'TOP_RIGHT_BOXAD',
			providerName: 'direct',
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'EMPTY_RESPONSE;0-1.0',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00;0-1.0'
				}
			},
			expected: undefined,
			message: 'Return undefined when slot is not supported by adapter'
		}].forEach(function (testCase) {
			var module = getModule(),
				result;

			spyOn(mocks.adTracker, 'track');

			result = module.trackBidderSlotState(testCase.adapter, testCase.slotName, testCase.providerName, testCase.performanceMap);

			expect(result).toEqual(testCase.expected, testCase.message);
			expect(mocks.adTracker.track).not.toHaveBeenCalled();

			mocks.adTracker.track = noop;
		});
	});

	it('trackBidderSlotState works when adapter enabled and slot is supported', function () {
		[{
			adapter: mocks.adapterIndexExchange,
			slotName: 'TOP_LEADERBOARD',
			providerName: 'direct',
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'EMPTY_RESPONSE;0-1.0',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00;0-1.0'
				}
			},
			expected: ['indexExchange/lookup_success/direct', 'TOP_LEADERBOARD', 0, '200x200;1.00;0-1.0']
		}, {
			adapter: mocks.adapterAppNexus,
			slotName: 'TOP_RIGHT_BOXAD',
			providerName: 'remnant',
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'EMPTY_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00;0-1.0'
				}
			},
			expected: ['appnexus/lookup_error/remnant', 'TOP_RIGHT_BOXAD', 0, 'nodata']
		}, {
			adapter: mocks.adapterAppNexus,
			slotName: 'TOP_RIGHT_BOXAD',
			providerName: 'direct',
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'EMPTY_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00;0-1.0'
				}
			},
			expected: ['appnexus/lookup_error/direct', 'TOP_RIGHT_BOXAD', 0, 'nodata']
		}].forEach(function (testCase) {
			var module = getModule(),
				expectResult;

			spyOn(mocks.adTracker, 'track');

			module.trackBidderSlotState(testCase.adapter, testCase.slotName, testCase.providerName, testCase.performanceMap);
			expectResult = expect(mocks.adTracker.track);
			expectResult.toHaveBeenCalledWith.apply(expectResult, testCase.expected);

			mocks.adTracker.track = noop;
		});
	});
});
