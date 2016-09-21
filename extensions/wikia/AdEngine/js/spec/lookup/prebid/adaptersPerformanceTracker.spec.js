/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker', function () {
	'use strict';

	var mocks = {
			adTracker: {
				track: noop
			},
			win: {
				pbjs: {
					getBidResponses: noop
				}
			},
			adapterAppNexus: {
				getName: function () {
					return 'appnexus'
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
					return 'indexExchange'
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
				getSize: function() {
					return '200x200';
				}
			},
			correctAppNexusBid: {
				bidder: 'appnexus',
				pbMg: '0.00',
				getStatusCode: function () {
					return 1;
				},
				getSize: function() {
					return '100x100';
				}
			},
			emptyAppNexusBid: {
				bidder: 'appnexus',
				getStatusCode: function() {
					return 2;
				}
			}
		},
		module,
		getBidResponsesSpy;

	function noop() {
	}

	function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.adaptersPerformanceTracker'](
			mocks.adTracker,
			mocks.win
		);
	}

	beforeEach(function () {
		module = getModule();
		getBidResponsesSpy = spyOn(mocks.win.pbjs, 'getBidResponses');
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
					TOP_LEADERBOARD: 'NOT_RESPONDED',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				}
			}
		}, {
			skin: 'oasis',
			adapters: [
				mocks.adapterAppNexus,
				mocks.adapterIndexExchange
			],
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'NOT_RESPONDED',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NOT_RESPONDED'
				}
			}
		}].forEach(function (testCase) {
			var result = module.setupPerformanceMap(testCase.skin, testCase.adapters);

			expect(result).toEqual(testCase.expected, testCase.message);
		});
	});

	it('updatePerformanceMap updates the map structure correctly', function () {
		[{
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NOT_RESPONDED',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NOT_RESPONDED'
				}
			},
			allBids: {},
			expected: {
				appnexus: {
					TOP_LEADERBOARD: 'NOT_RESPONDED',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NOT_RESPONDED'
				}
			},
			message: 'if no bids are returned map stays untouched'
		}, {
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NOT_RESPONDED',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NOT_RESPONDED'
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
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00'
				}
			},
			message: 'Only returned bids are updated in map'
		}, {
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NOT_RESPONDED',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NOT_RESPONDED'
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
					TOP_LEADERBOARD: 'EMPTY',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: '200x200;1.00'
				}
			},
			message: 'if no bids for slot are returned map stays untouched'
		}, {
			performanceMap: {
				appnexus: {
					TOP_LEADERBOARD: 'NOT_RESPONDED',
					TOP_RIGHT_BOXAD: 'NOT_RESPONDED'
				},
				indexExchange: {
					TOP_LEADERBOARD: 'NOT_RESPONDED'
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
					TOP_LEADERBOARD: 'NOT_RESPONDED'
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
});
