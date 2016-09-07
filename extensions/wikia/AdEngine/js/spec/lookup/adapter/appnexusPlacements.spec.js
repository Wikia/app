describe('ext.wikia.adEngine.lookup.adapter.appnexusPlacements', function () {
	'use strict';

	var mocks = {
		adLogicZoneParams: {
			getVertical: function () {
			}
		}, env: {
			isDevEnvironment: function () {
			}
		}
	}, testCases = [
		{
			vertical: 'lifestyle',
			skin: 'mercury',
			isDev: false,
			expected: '9412994'
		}, {
			vertical: 'gaming',
			skin: 'mercury',
			isDev: true,
			expected: '9412981'
		}, {
			vertical: 'entertainment',
			skin: 'mercury',
			isDev: false,
			expected: '9412992'
		}, {
			vertical: 'lifestyle',
			skin: 'oasis',
			isDev: true,
			expected: '9412973'
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			isDev: true,
			expected: '9412972'
		}, {
			vertical: 'entertainment',
			skin: 'oasis',
			isDev: true,
			expected: '9412971'
		}, {
			vertical: 'entertainment',
			skin: 'oasis',
			isDev: false,
			expected: '9412983'
		}
	];

	function getModule(vertical, isDev) {
		mocks.adLogicZoneParams.getVertical = function () {
			return vertical;
		};

		mocks.env.isDevEnvironment = function () {
			return isDev;
		};

		return modules['ext.wikia.adEngine.lookup.adapter.appnexusPlacements'](
			mocks.adLogicZoneParams,
			mocks.env
		);
	}


	testCases.forEach(function (testCase) {
		it('expected placementId is returned for skin/vertical combination ', function () {
			var appNexusPlacements = getModule(testCase.vertical, testCase.isDev),
				result = appNexusPlacements.getPlacement(testCase.skin);

			expect(result).toEqual(testCase.expected);
		});
	});
});
