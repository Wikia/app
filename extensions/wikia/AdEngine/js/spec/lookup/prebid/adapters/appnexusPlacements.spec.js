/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return mocks.context;
			}
		},
		context: {
			targeting: {
				mappedVerticalName: ''
			}
		},
		log: function() {},
		instantGlobals: {
			dev: {
				wgAdDriverAppNexusBidderPlacementsConfig: {
					mercury: {
						entertainment: "111111",
						gaming: "111112",
						lifestyle: "111113",
						other: "111114"
					},
					oasis: {
						entertainment: {
							atf: '899999',
							btf: '899998',
							hivi: '899997'
						},
						gaming: {
							atf: '899996',
							btf: '899995',
							hivi: '899994'
						},
						lifestyle: {
							atf: '899993',
							btf: '899992',
							hivi: '899991'
						},
						other: {
							atf: '899990',
							btf: '899989',
							hivi: '899988'
						},
						recovery: {
							atf: '899987',
							btf: '899986',
							hivi: '899985'
						}
					}
				}
			},
			prod: {
				wgAdDriverAppNexusBidderPlacementsConfig: {
					mercury: {
						entertainment: '222222',
						gaming: '222223',
						lifestyle: '222224',
						other: '222225'
					},
					oasis: {
						entertainment: {
							atf: '999999',
							btf: '999998',
							hivi: '999997'
						},
						gaming: {
							atf: '999996',
							btf: '999995',
							hivi: '999994'
						},
						lifestyle: {
							atf: '999993',
							btf: '999992',
							hivi: '999991'
						},
						other: {
							atf: '999990',
							btf: '999989',
							hivi: '999988'
						},
						recovery: {
							atf: '999987',
							btf: '999986',
							hivi: '999985'
						}
					}
			}
		}
	}
	}, testCases = [
		{
			vertical: 'lifestyle',
			skin: 'mercury',
			env: 'dev',
			expected: '111113'
		}, {
			vertical: 'lifestyle',
			skin: 'oasis',
			env: 'dev',
			pos: 'atf',
			expected: '899993'
		}, {
			vertical: 'entertainment',
			skin: 'mercury',
			env: 'prod',
			expected: '222222'
		}, {
			vertical: 'other',
			skin: 'mercury',
			env: 'prod',
			expected: '222225'
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			env: 'prod',
			pos: 'atf',
			expected: '999996'
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			env: 'prod',
			pos: 'btf',
			expected: '999995'
		}, {
			vertical: 'entertainment',
			skin: 'oasis',
			env: 'prod',
			pos: 'btf',
			recovery: false,
			expected: '999998'
		}, {
			vertical: 'entertainment',
			skin: 'oasis',
			env: 'prod',
			pos: 'atf',
			recovery: true,
			expected: '999987'
		}, {
			vertical: 'lifestyle',
			skin: 'oasis',
			env: 'prod',
			pos: 'hivi',
			recovery: true,
			expected: '999985'
		},{
			vertical: 'NOT EXISTING',
			skin: 'oasis',
			env: 'prod',
			pos: 'btf',
			expected: undefined
		}
	];

	function getModule(vertical, env) {
		mocks.context.targeting.mappedVerticalName = vertical;

		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements'](
			mocks.adContext,
			mocks.instantGlobals[env],
			mocks.log
		);
	}

	testCases.forEach(function (testCase) {
		it('returns expected placementId for ' + testCase.skin + ':' + testCase.vertical + ':' + testCase.env, function () {
			var appNexusPlacements = getModule(testCase.vertical, testCase.env),
				result = appNexusPlacements.getPlacement(testCase.skin, testCase.pos, testCase.recovery);

			expect(result).toEqual(testCase.expected);
		});
	});
})
;
