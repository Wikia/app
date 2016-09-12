describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', function () {
	'use strict';

	var mocks = {
		adLogicZoneParams: {
			getVertical: function () {
			}
		}, instantGlobals: {
			dev: {
				wgAdDriverAppNexusBidderPlacementsConfig: {
					mercury: {
						entertainment: "9412980",
						gaming: "9412981",
						lifestyle: "9412982",
						other: "9412982"
					},
					oasis: {
						entertainment: '9412971',
						gaming: '9412972',
						lifestyle: '9412973',
						other: '9412973'
					}
				}
			},
			prod: {
				wgAdDriverAppNexusBidderPlacementsConfig: {
					mercury: {
						entertainment: '9412992',
						gaming: '9412993',
						lifestyle: '9412994',
						other: '9412994'
					}
				},
				oasis: {
					entertainment: '9412983',
					gaming: '9412984',
					lifestyle: '9412985',
					other: '9412985'
				}
			}
		}
	}, testCases = [
		{
			vertical: 'lifestyle',
			skin: 'mercury',
			env: 'prod',
			expected: '9412994'
		}, {
			vertical: 'gaming',
			skin: 'mercury',
			env: 'dev',
			expected: '9412981'
		}, {
			vertical: 'entertainment',
			skin: 'mercury',
			env: 'prod',
			expected: '9412992'
		}, {
			vertical: 'other',
			skin: 'mercury',
			env: 'prod',
			expected: '9412994'
		}, {
			vertical: 'lifestyle',
			skin: 'oasis',
			env: 'dev',
			expected: '9412973'
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			env: 'dev',
			expected: '9412972'
		}, {
			vertical: 'entertainment',
			skin: 'oasis',
			env: 'dev',
			expected: '9412971'
		}
	];

	function getModule(vertical, env) {
		mocks.adLogicZoneParams.getVertical = function () {
			return vertical;
		};

		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements'](
			mocks.adLogicZoneParams,
			mocks.instantGlobals[env]
		);
	}


	testCases.forEach(function (testCase) {
		it('expected placementId is returned for skin/vertical combination ', function () {
			var appNexusPlacements = getModule(testCase.vertical, testCase.env),
				result = appNexusPlacements.getPlacement(testCase.skin);

			expect(result).toEqual(testCase.expected);
		});
	});
})
;
