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
				pbMg: '1.00',
				getStatusCode: function () {
					return 1;
				},
				getSize: function () {
					return '200x200';
				}
			},
			correctAppNexusBid: {
				bidder: 'appnexus',
				pbMg: '0.00',
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
				pbMg: '5.00',
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
			}
		},
		module,
		getBidResponsesSpy;

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker'](
			mocks.adTracker,
			mocks.prebid
		);
	}

	beforeEach(function () {
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
		}].forEach(function (testCase) {
			var result = module.setupPerformanceMap(testCase.skin, testCase.adapters);

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
					TOP_LEADERBOARD: '100x100;0.00',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00'
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
					TOP_LEADERBOARD: 'EMPTY_RESPONSE',
					TOP_RIGHT_BOXAD: 'NO_RESPONSE'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00'
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
					TOP_LEADERBOARD: '100x100;0.00',
					TOP_RIGHT_BOXAD: '100x100;0.00'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			message: 'if no bids for one bidder are returned map stays untouched'
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
						mocks.completeAppNexusBid
					]
				}, TOP_RIGHT_BOXAD: {
					bids: [
						mocks.correctAppNexusBid
					]
				}
			},
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'USED',
					TOP_RIGHT_BOXAD: '100x100;0.00'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NO_RESPONSE'
				}
			},
			message: 'rendered bid is tracked as used'
		}].forEach(function (testCase) {
			var result;

			getBidResponsesSpy.and.returnValue(testCase.allBids);
			result = module.updatePerformanceMap(testCase.performanceMap);

			expect(result).toEqual(testCase.expected, testCase.message);
		});
	});
});
