describe('ext.wikia.adEngine.lookup.adapter.appnexusPlacements', function () {
	'use strict';

	var mocks = {
		adLogicZoneParams: {
			getVertical: function() {}
		},
		window: {
			location: {
				host: ''
			}
		}
	}, testCases = [
		{
			vertical: 'lifestyle',
			skin: 'mercury',
			host: 'http://muppet.wikia.com',
			expected: '9412994'
		}, {
			vertical: 'gaming',
			skin: 'mercury',
			host: 'http://muppet.john.wikia-dev.com',
			expected: '9412981'
		}, {
			vertical: 'entertainment',
			skin: 'mercury',
			host: 'http://wowwiki.com',
			expected: '9412992'
		}, {
			vertical: 'lifestyle',
			skin: 'oasis',
			host: 'http://muppet.john.wikia-dev.com',
			expected: '9412973'
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			host: 'http://muppet.wikia.com',
			expected: '9412984'
		}, {
			vertical: 'entertainment',
			skin: 'oasis',
			host: 'http://wowwiki.com',
			expected: '9412983'
		}
	];

	function getModule(vertical, host) {
		mocks.adLogicZoneParams.getVertical = function() {
			return vertical;
		};

		mocks.window.location.host = host;

		return modules['ext.wikia.adEngine.lookup.adapter.appnexusPlacements'](
			mocks.adLogicZoneParams,
			mocks.window
		);
	}


	testCases.forEach(function(testCase) {
		it('expected placementId is returned for skin/vertical combination ', function() {
			var appNexusPlacements = getModule(testCase.vertical, testCase.host),
				result = appNexusPlacements.getPlacement(testCase.skin);

			expect(result).toEqual(testCase.expected);
		})
	});
});
